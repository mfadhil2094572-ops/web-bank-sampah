// Dashboard/admin small UX helpers
const APP_API_BASE = (window.APP_API_BASE || '').replace(/\/$/, '');
document.addEventListener('click', async (e) => {
    const btn = e.target.closest('[data-approve-btn]');
    if (!btn) return;
    e.preventDefault();
    const txId = btn.getAttribute('data-tx-id');
    const action = btn.getAttribute('data-action');
    if (!txId || !action) return;
    if (!confirm(`Are you sure to ${action} transaction #${txId}?`)) return;
    try {
        const form = new URLSearchParams();
        form.append('transaction_id', txId);
        form.append('action', action);
        const res = await fetch((APP_API_BASE || '') + '/api/admin/admin_approve.php', {method: 'POST', body: form, credentials: 'include'});
        if (res.redirected) {
            window.location.href = res.url;
            return;
        }
        const text = await res.text();
        alert(text || 'Done');
        // remove card from UI
        const card = btn.closest('.tx-card');
        if (card) card.remove();
    } catch (err) {
        console.error(err);
        alert('Gagal memproses. Cek konsol.');
    }
});
