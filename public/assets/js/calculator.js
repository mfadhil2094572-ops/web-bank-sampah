// Calculator interactions: fetch estimate and manage client cart
let cart = [];

async function updateCalculation() {
    const type = document.getElementById('wasteType').value;
    const weight = document.getElementById('weight').value;
    const selected = document.getElementById('wasteType');
    const name = selected.options[selected.selectedIndex]?.text || '-';

    document.getElementById('selectedWaste').textContent = name;
    if (!type || !weight || parseFloat(weight) <= 0) {
        document.getElementById('pricePerKg').textContent = 'Rp 0';
        document.getElementById('totalWeight').textContent = '0 kg';
        document.getElementById('totalPrice').textContent = 'Rp 0';
        document.getElementById('totalPoints').textContent = '0 Poin';
        return;
    }

    try {
        const res = await fetch(`/api/transaction/estimate.php?type_id=${encodeURIComponent(type)}&weight=${encodeURIComponent(weight)}`, {credentials: 'same-origin'});
        const json = await res.json();
        document.getElementById('pricePerKg').textContent = json.price && weight ? `Rp ${numberWithSep(Math.round(json.price/weight))}` : 'Rp 0';
        document.getElementById('totalWeight').textContent = `${weight} kg`;
        document.getElementById('totalPrice').textContent = `Rp ${numberWithSep(json.price)}`;
        document.getElementById('totalPoints').textContent = `${numberWithSep(json.points)} Poin`;
    } catch (e) {
        console.error(e);
    }
}

function numberWithSep(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function setWeight(v) {
    document.getElementById('weight').value = v;
    updateCalculation();
}

function addToCart() {
    const sel = document.getElementById('wasteType');
    const typeId = sel.value;
    if (!typeId) return alert('Pilih jenis sampah');
    const typeName = sel.options[sel.selectedIndex].text;
    const weight = parseFloat(document.getElementById('weight').value || 0);
    if (!weight || weight <= 0) return alert('Masukkan berat yang valid');

    // fetch estimate and add
    fetch(`/api/transaction/estimate.php?type_id=${encodeURIComponent(typeId)}&weight=${encodeURIComponent(weight)}`, {credentials: 'same-origin'})
        .then(r => r.json())
        .then(json => {
            cart.push({typeId: parseInt(typeId), typeName, weight, price: json.price, points: json.points});
            renderCart();
        })
        .catch(err => { console.error(err); alert('Gagal mengambil estimasi'); });
}

function renderCart() {
    const body = document.getElementById('cartItems');
    if (!cart.length) {
        body.innerHTML = `<div class="empty-cart"><i class="fas fa-inbox"></i><p>Keranjang kosong. Tambahkan sampah terlebih dahulu.</p></div>`;
        updateSummary();
        return;
    }
    body.innerHTML = '';
    cart.forEach((it, idx) => {
        const div = document.createElement('div');
        div.className = 'cart-row';
        div.innerHTML = `
            <div class="col-type">${escapeHtml(it.typeName)}</div>
            <div class="col-weight">${it.weight} kg</div>
            <div class="col-price">Rp ${numberWithSep(it.price)}</div>
            <div class="col-points">${numberWithSep(it.points)} Poin</div>
            <div class="col-action"><button onclick="removeCart(${idx})">Hapus</button></div>
        `;
        body.appendChild(div);
    });
    updateSummary();
}

function removeCart(i) {
    cart.splice(i,1);
    renderCart();
}

function updateSummary() {
    const sumW = cart.reduce((s,i)=>s+i.weight,0);
    const sumP = cart.reduce((s,i)=>s+i.price,0);
    const sumPts = cart.reduce((s,i)=>s+i.points,0);
    document.getElementById('summaryWeight').textContent = `${sumW} kg`;
    document.getElementById('summaryPrice').textContent = `Rp ${numberWithSep(sumP)}`;
    document.getElementById('summaryPoints').textContent = `${numberWithSep(sumPts)} Poin`;
}

async function submitWaste() {
    if (!cart.length) return alert('Keranjang kosong');
    try {
        for (const item of cart) {
            const form = new URLSearchParams();
            form.append('waste_type_id', item.typeId);
            form.append('weight', item.weight);
            const res = await fetch('/api/transaction/transactions_create.php', {method: 'POST', body: form, headers: {'Accept': 'application/json'}, credentials: 'same-origin'});
            const json = await res.json();
            if (!res.ok) throw new Error(json.error || 'Error');
        }
        alert('Semua item dikirim sebagai transaksi pending. Anda akan diarahkan ke riwayat.');
        window.location.href = '/transactions';
    } catch(e) {
        console.error(e);
        alert('Gagal mengirim beberapa item. Periksa konsol.');
    }
}

function escapeHtml(s){ return String(s).replace(/[&<>"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c])); }
