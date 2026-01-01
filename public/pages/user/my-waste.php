<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login();
$stmt = $pdo->query('SELECT id, name FROM waste_types ORDER BY name');
$waste_types = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampah Saya - Dashboard Bank Sampah</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
                <div class="navbar-container">
            <div class="navbar-logo">
                <i class="fas fa-leaf"></i>
                <span>Bank Sampah</span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/">Beranda</a></li>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/profile">Profil</a></li>
                <li><a href="/logout" class="btn-login">Keluar</a></li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h3>Menu</h3>
            </div>
            <nav class="sidebar-nav">
                <a href="/dashboard" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/my-waste" class="nav-item active">
                    <i class="fas fa-trash"></i>
                    <span>Sampah Saya</span>
                </a>
                <a href="/transactions" class="nav-item">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transaksi</span>
                </a>
                <?php $__me = bs_get_current_user(); if ($__me && ($__me['role'] ?? '') === 'admin'): ?>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Manajemen <button class="manajemen-toggle" aria-label="Toggle Manajemen">▾</button></div>
                    <nav class="sidebar-subnav">
                        <a href="/admin/transactions" class="nav-item"><i class="fas fa-check-circle"></i><span>Kelola Laporan</span></a>
                        <a href="/admin/pickups" class="nav-item"><i class="fas fa-truck"></i><span>Kelola Penjemputan</span></a>
                        <a href="/admin/members" class="nav-item"><i class="fas fa-users"></i><span>Anggota</span></a>
                    </nav>
                </div>
                <?php endif; ?>
                <a href="/rewards" class="nav-item">
                    <i class="fas fa-gift"></i>
                    <span>Reward</span>
                </a>
                <a href="/pickup" class="nav-item">
                    <i class="fas fa-truck"></i>
                    <span>Jemput Sampah</span>
                </a>
                <a href="/profile" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
                <a href="#" onclick="logout()" class="nav-item logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <div>
                    <h1>Sampah Saya</h1>
                    <p>Kelola dan pantau semua sampah yang Anda kumpulkan</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="openAddWasteModal()">
                        <i class="fas fa-plus"></i> Lapor Sampah Baru
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <input type="text" placeholder="Cari sampah..." class="search-input">
                <select class="filter-select">
                    <option>Semua Status</option>
                    <option>Menunggu</option>
                    <option>Disetujui</option>
                    <option>Ditolak</option>
                </select>
            </div>

            <!-- Waste List -->
            <div class="waste-list" id="wasteList">
                <!-- populated by JS -->
            </div>

            <!-- Empty State -->
            <div class="empty-state" style="display:none;">
                <i class="fas fa-inbox"></i>
                <h3>Belum ada laporan sampah</h3>
                <p>Mulai laporkan sampah Anda untuk mendapatkan poin dan uang</p>
                <button class="btn btn-primary" onclick="openAddWasteModal()">Lapor Sampah Pertama</button>
            </div>
        </main>
    </div>

    <!-- Add Waste Modal -->
            <div id="addWasteModal" class="modal">
        <div class="modal-content" style="max-width: 500px;">
            <span class="close" onclick="closeAddWasteModal()">&times;</span>
            <h2>Lapor Sampah Baru</h2>
            <form class="form" id="wasteForm" action="/transactions_create" method="POST">
                <div class="form-group">
                    <label>Jenis Sampah</label>
                    <select name="waste_type_id" required>
                        <option value="">-- Pilih Jenis --</option>
                        <?php foreach ($waste_types as $t): ?>
                            <option value="<?= (int)$t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Berat (kg)</label>
                    <input type="number" name="weight" placeholder="0.00" step="0.1" required>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="note" placeholder="Deskripsi sampah..." rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Laporkan</button>
            </form>
        </div>
    </div>
    <div class="sidebar-backdrop" onclick="document.querySelector('.sidebar') && document.querySelector('.sidebar').classList.remove('open'); document.body.style.overflow='';"></div>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 50px;">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2024 Bank Sampah Indonesia. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script>
        async function fetchWaste(q = '', status = ''){
            const url = new URL('/my_waste', window.location.origin);
            if (q) url.searchParams.set('q', q);
            if (status) url.searchParams.set('status', status);
            const res = await fetch(url);
            const jr = await res.json();
            const container = document.getElementById('wasteList');
            container.innerHTML = '';
            if (!jr.success || !jr.data.length) {
                document.querySelector('.empty-state').style.display = 'block';
                return;
            }
            document.querySelector('.empty-state').style.display = 'none';
            jr.data.forEach(item => {
                const div = document.createElement('div');
                div.className = 'waste-item';
                const statusBadge = item.status === 'pending' ? '<span class="badge badge-pending">Menunggu Verifikasi</span>' : (item.status === 'approved' ? '<span class="badge badge-approved">Disetujui</span>' : '<span class="badge badge-rejected">Ditolak</span>');
                div.innerHTML = `
                    <div class="waste-header">
                        <h3>${escapeHtml(item.waste_name)}</h3>
                        ${statusBadge}
                    </div>
                    <div class="waste-details">
                        <div class="detail-row"><span>Berat:</span><strong>${item.weight} kg</strong></div>
                        <div class="detail-row"><span>Tanggal Lapor:</span><strong>${item.created_at}</strong></div>
                        <div class="detail-row"><span>Nilai:</span><strong>Rp ${Number(item.price).toLocaleString()}</strong></div>
                        <div class="detail-row"><span>Poin:</span><strong>${Number(item.points).toLocaleString()} Poin</strong></div>
                    </div>
                    <div class="waste-actions">
                        ${item.status === 'pending' ? `<button class="btn btn-small btn-primary" onclick="openEdit(${item.id}, ${item.weight})">Edit</button>
                        <button class="btn btn-small btn-secondary" onclick="del(${item.id})">Hapus</button>` : `<button class="btn btn-small btn-primary" onclick="viewDetail(${item.id})">Detail</button>`}
                    </div>`;
                container.appendChild(div);
            });
        }

        function escapeHtml(s){ return String(s).replace(/[&<>\"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

        async function del(id){
            if (!confirm('Hapus item ini?')) return;
            const form = new FormData(); form.append('action','delete'); form.append('id',id);
            const res = await fetch('/my_waste.php',{method:'POST',body:form, credentials: 'same-origin'}); const jr = await res.json();
            if (typeof notify === 'function') notify(jr.message || 'Selesai', jr.success ? 'success' : 'error'); else alert(jr.message || 'Selesai');
            fetchWaste(document.querySelector('.search-input').value, document.querySelector('.filter-select').value.toLowerCase());
        }

        function openEdit(id, weight){
            const modal = document.getElementById('editModal');
            modal.querySelector('[name="id"]').value = id;
            modal.querySelector('[name="weight"]').value = weight;
            modal.classList.add('show');
        }

        async function saveEdit(e){
            e.preventDefault();
            const f = new FormData(e.target); f.append('action','update');
            const res = await fetch('/my_waste.php',{method:'POST',body:f, credentials: 'same-origin'}); const jr = await res.json();
            if (typeof notify === 'function') notify(jr.message || 'Selesai', jr.success ? 'success' : 'error'); else alert(jr.message || 'Selesai');
            document.getElementById('editModal').classList.remove('show');
            fetchWaste(document.querySelector('.search-input').value, document.querySelector('.filter-select').value.toLowerCase());
        }

        function viewDetail(id){
            // for simplicity open transaction detail page
            window.location.href = '/transactions?tx=' + id;
        }

        document.querySelector('.search-input').addEventListener('input', (e)=> fetchWaste(e.target.value, document.querySelector('.filter-select').value.toLowerCase()));
        document.querySelector('.filter-select').addEventListener('change', (e)=> fetchWaste(document.querySelector('.search-input').value, e.target.value.toLowerCase()));

        // modal open/close helpers
        function openAddWasteModal(){ document.getElementById('addWasteModal').classList.add('show'); }
        function closeAddWasteModal(){ document.getElementById('addWasteModal').classList.remove('show'); }

        // AJAX submit for adding waste to avoid full-page redirect
        document.getElementById('wasteForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const f = new FormData(this);
            try {
                const res = await fetch(this.action, {method: 'POST', body: f, headers: {'Accept':'application/json'}});
                const jr = await res.json();
                if (jr && jr.ok) {
                    if (typeof notify === 'function') notify('Laporan sampah berhasil dibuat', 'success');
                    closeAddWasteModal();
                    fetchWaste();
                    this.reset();
                    return;
                }
                if (jr && jr.error) {
                    if (typeof notify === 'function') notify(jr.error, 'error'); else alert(jr.error||'Gagal');
                } else {
                    if (typeof notify === 'function') notify('Gagal membuat laporan', 'error');
                }
            } catch (err) {
                console.error(err);
                if (typeof notify === 'function') notify('Terjadi kesalahan', 'error');
            }
        });

        document.getElementById('editForm').addEventListener('submit', saveEdit);

        fetchWaste();
    </script>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content" style="max-width:400px;">
            <span class="close" onclick="document.getElementById('editModal').classList.remove('show')">&times;</span>
            <h3>Edit Laporan Sampah</h3>
            <form id="editForm" class="form">
                <input type="hidden" name="id">
                <div class="form-group">
                    <label>Berat (kg)</label>
                    <input name="weight" type="number" step="0.1" required>
                </div>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    <style>
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .search-input, .filter-select {
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            min-width: 200px;
        }

        .search-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .waste-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .waste-item {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .waste-item:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .waste-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        .waste-header h3 {
            margin: 0;
            color: var(--dark-color);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background-color: #fee2e2;
            color: #7f1d1d;
        }

        .waste-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            color: var(--text-color);
        }

        .detail-row strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .waste-actions {
            display: flex;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-color);
        }

        .empty-state i {
            font-size: 64px;
            color: var(--border-color);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: var(--dark-color);
        }
    </style>
</body>
</html>
