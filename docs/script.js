// Global UI helpers
async function logout() {
    try {
        const res = await fetch('/api/auth/logout.php', {credentials: 'same-origin'});
        const jr = await res.json();
        if (jr.redirect) window.location.href = jr.redirect; else window.location.href = '/login';
    } catch (e) {
        window.location.href = '/login';
    }
}

function toggleMobileMenu() {
    // Prefer toggling sidebar if present (mobile sidebar behavior)
    const sidebar = document.querySelector('.sidebar');
    const nav = document.getElementById('navMenu');
    const hb = document.querySelector('.hamburger');
    if (sidebar) {
        sidebar.classList.toggle('open');
        if (hb) hb.classList.toggle('open');
        // prevent body scroll when sidebar open
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        return;
    }
    if (!nav) return;
    nav.classList.toggle('show');
    if (hb) hb.classList.toggle('open');
}

document.addEventListener('click', (e) => {
    if (e.target.closest('.hamburger')) toggleMobileMenu();
});

// Inject hamburger button into navbars if missing
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.navbar').forEach(nav => {
        if (nav.querySelector('.hamburger')) return;
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'hamburger';
        btn.setAttribute('aria-label', 'Toggle menu');
        btn.innerHTML = '<span></span><span></span><span></span>';
        const container = nav.querySelector('.navbar-container') || nav;
        // insert before nav menu
        const menu = nav.querySelector('.nav-menu');
        if (menu) container.insertBefore(btn, menu);
    });
    // inject notification bell into navbar-container if missing
    document.querySelectorAll('.navbar-container').forEach(container => {
        if (container.querySelector('.bs-notify')) return;
        const wrap = document.createElement('div');
        wrap.className = 'bs-notify';
        wrap.style.marginLeft = '12px';
        wrap.innerHTML = `
            <button class="notify-btn" aria-label="Notifications">
                <span class="bell"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6 6 0 0 0-5-5.917V4a1 1 0 0 0-2 0v1.083A6 6 0 0 0 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
                <span class="badge" style="display:none">0</span>
            </button>
            <div class="notify-dropdown" style="display:none"></div>
        `;
        // insert before nav menu or at end
        const menu = container.querySelector('.nav-menu');
        if (menu) container.insertBefore(wrap, menu);
        else container.appendChild(wrap);
    });
    // initialize Manajemen toggle state
    try {
        const collapsed = localStorage.getItem('bs_manajemen_collapsed') === '1';
        document.querySelectorAll('.sidebar-section').forEach(sec=>{
            const toggle = sec.querySelector('.manajemen-toggle');
            if (!toggle) return;
            const sub = sec.querySelector('.sidebar-subnav');
            if (collapsed) { sub.style.display = 'none'; toggle.textContent = '▸'; }
            toggle.addEventListener('click', ()=>{
                const isHidden = (sub.style.display === 'none');
                sub.style.display = isHidden ? '' : 'none';
                toggle.textContent = isHidden ? '▾' : '▸';
                localStorage.setItem('bs_manajemen_collapsed', isHidden ? '0' : '1');
            });
        });
    } catch(e){}

    // admin quick actions
    document.querySelectorAll('.admin-quick').forEach(b=>{
        b.addEventListener('click', async (e)=>{
            const action = b.getAttribute('data-action');
            if (!confirm('Yakin ingin menjalankan aksi cepat: ' + b.textContent + '?')) return;
            try {
                const f = new FormData(); f.append('action', action);
                const res = await fetch('/api/admin/admin_quick.php', {method:'POST', body: f, credentials: 'same-origin'});
                const jr = await res.json();
                if (jr.success) {
                    if (typeof notify === 'function') notify(jr.message || 'Selesai', 'success');
                    // small visual cue: reload current page to reflect change
                    setTimeout(()=> location.reload(), 800);
                } else {
                    if (typeof notify === 'function') notify(jr.message || 'Gagal', 'error');
                }
            } catch(err){ console.error(err); if (typeof notify === 'function') notify('Error', 'error'); }
        });
    });
    // notification bell behavior: fetch and render
    try {
        async function fetchNotifications() {
            try {
                const res = await fetch('/api/user/notifications.php', {credentials: 'same-origin'});
                const jr = await res.json();
                document.querySelectorAll('.bs-notify').forEach(node=>{
                    const btn = node.querySelector('.notify-btn');
                    const badge = node.querySelector('.badge');
                    const dd = node.querySelector('.notify-dropdown');
                    if (!jr.success || !jr.data.length) {
                        badge.style.display = 'none'; dd.innerHTML = '<div class="nd-empty">Tidak ada notifikasi</div>'; return;
                    }
                    // show count
                    badge.textContent = jr.data.length; badge.style.display = 'inline-block';
                    dd.innerHTML = jr.data.slice(0,8).map(it=>{
                        const time = it.time || '';
                        const subj = it.subj || '';
                        const msg = it.msg || it.message || '';
                        return `<div class="nd-item"><div class="nd-title">${escapeHtml(subj)}</div><div class="nd-msg">${escapeHtml(msg)}</div><div class="nd-time">${escapeHtml(time)}</div></div>`;
                    }).join('');
                });
            } catch(e){ console.error(e); }
        }
        fetchNotifications();
        // poll every 60s
        setInterval(fetchNotifications, 60000);

        // toggle dropdown
        document.addEventListener('click', (e)=>{
            const btn = e.target.closest('.notify-btn');
            if (btn) {
                const node = btn.closest('.bs-notify');
                const dd = node.querySelector('.notify-dropdown');
                dd.style.display = dd.style.display === 'block' ? 'none' : 'block';
                return;
            }
            // close any open dropdowns
            document.querySelectorAll('.notify-dropdown').forEach(d=>{ if (!d.contains(e.target)) d.style.display = 'none'; });
        });
    } catch(e){}

    // animate stat values (numeric rise)
    try {
        document.querySelectorAll('.stat-value').forEach(el=>{
            const txt = el.textContent.replace(/[^0-9]/g,'');
            const target = parseInt(txt||'0',10);
            if (!target) return;
            let cur = 0; const step = Math.max(1, Math.floor(target/60));
            const intv = setInterval(()=>{
                cur += step; if (cur >= target) { cur = target; clearInterval(intv); }
                el.textContent = el.textContent.includes('Rp') ? ('Rp ' + cur.toLocaleString()) : cur.toLocaleString() + (el.textContent.match(/kg/) ? ' kg' : '');
            }, 12);
        });
    } catch(e){}
});

function closeModal() {
    const m = document.getElementById('successModal');
    if (m) m.classList.remove('show');
}

// ===========================
// NOTIFICATION / TOAST
// ===========================
function notify(message, type = 'info', timeout = 3500) {
    const containerId = 'bs_toast_container';
    let container = document.getElementById(containerId);
    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = 10001;
        document.body.appendChild(container);
    }
    const el = document.createElement('div');
    el.className = 'bs-toast bs-toast-' + type;
    el.style.cssText = 'background:#111;color:#fff;padding:12px 18px;margin-bottom:10px;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,0.12);max-width:320px;';
    if (type === 'success') el.style.background = '#10b981';
    if (type === 'error') el.style.background = '#ef4444';
    el.textContent = message;
    container.appendChild(el);
    setTimeout(() => { el.style.opacity = '0'; setTimeout(()=>el.remove(),300); }, timeout);
}

// show messages from query string: ?success=.. or ?error=..
(function(){
    try {
        const params = new URLSearchParams(window.location.search);
        if (params.get('success')) notify(params.get('success'), 'success');
        if (params.get('error')) notify(params.get('error'), 'error');
    } catch(e){}
})();
