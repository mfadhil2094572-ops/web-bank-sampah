function toggleForms() {
    const login = document.getElementById('loginForm');
    const reg = document.getElementById('registerForm');
    if (!login || !reg) return;
    if (login.style.display === 'none') {
        login.style.display = '';
        reg.style.display = 'none';
    } else {
        login.style.display = 'none';
        reg.style.display = '';
    }
}

function togglePassword(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.type = el.type === 'password' ? 'text' : 'password';
}

function redirectToDashboard() {
    window.location.href = '/dashboard';
}

// Optional: intercept register/login to show nicer errors without leaving page
const APP_API_BASE = (window.APP_API_BASE || '').replace(/\/$/, '');
document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (form.matches('#loginFormElement') || form.matches('#registerFormElement')) {
        e.preventDefault();
        const action = (form.getAttribute('action') || form.action).replace(/^\//, '');
        const url = (APP_API_BASE ? APP_API_BASE + '/' : '/') + action;
        const data = new FormData(form);
        try {
            const res = await fetch(url, {method: 'POST', body: data, headers: {'Accept':'application/json'}, credentials: 'include'});
            const contentType = res.headers.get('content-type') || '';
            if (contentType.indexOf('application/json') !== -1) {
                const jr = await res.json();
                if (jr.redirect) { window.location.href = jr.redirect; return; }
                alert(jr.message || 'Response received');
                return;
            }
            const text = await res.text();
            alert(text || 'Response received');
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan jaringan');
        }
    }
});
