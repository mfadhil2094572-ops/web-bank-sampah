<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login('admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Kelola Member</title>
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
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/">Beranda</a></li>
                <li><a href="/services">Layanan</a></li>
                <li class="user-profile">
                    <a href="#"><i class="fas fa-user-circle"></i> <span id="userName"><?= htmlspecialchars($user['full_name'] ?? 'User') ?></span></a>
                    <div class="dropdown-menu">
                        <a href="/dashboard">Dashboard</a>
                        <a href="/profile">Profil Saya</a>
                        <hr>
                        <a href="#" onclick="logout()">Keluar</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

 <div class="dashboard-container">

  <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>Menu</h3>
        </div>

        <nav class="sidebar-nav">
            <a href="/dashboard" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="/my-waste" class="nav-item">
                <i class="fas fa-trash"></i>
                <span>Sampah Saya</span>
            </a>

            <a href="/transactions" class="nav-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>

            <a href="/rewards" class="nav-item">
                <i class="fas fa-gift"></i>
                <span>Reward</span>
            </a>

            <a href="/pickup" class="nav-item">
                <i class="fas fa-truck"></i>
                <span>Jemput Sampah</span>
            </a>

            <?php if (($user['role'] ?? '') === 'admin'): ?>
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    Manajemen
                </div>
                <nav class="sidebar-subnav">
                    <a href="/admin/transactions" class="nav-item">
                        <i class="fas fa-check-circle"></i>
                        <span>Kelola Laporan</span>
                    </a>
                    <a href="/admin/pickups" class="nav-item">
                        <i class="fas fa-truck"></i>
                        <span>Kelola Penjemputan</span>
                    </a>
                    <a href="/admin/members" class="nav-item">
                        <i class="fas fa-users"></i>
                        <span>Anggota</span>
                    </a>
                </nav>
            </div>
            <?php endif; ?>

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
    
    <div class="container">
        <h1>Kelola Member</h1>

        <section style="margin-bottom:20px;">
            <h3>Tambah Member Baru</h3>
            <form id="createMemberForm">
                <input name="full_name" placeholder="Nama lengkap" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="password" type="password" placeholder="Password" required>
                <select name="role">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="btn btn-primary">Buat</button>
            </form>
            <div id="createMsg"></div>
        </section>

        <section>
            <h3>Daftar Member</h3>
            <table id="membersTable" class="table">
                <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                <tbody></tbody>
            </table>
        </section>
    </div>

    <script>
    async function loadMembers(){
        const res = await fetch('/admin/members', {credentials: 'same-origin'});
        const data = await res.json();
        const tbody = document.querySelector('#membersTable tbody');
        tbody.innerHTML = '';
        if (!data.success) return;
        data.data.forEach(m => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${m.id}</td><td>${m.full_name}</td><td>${m.email}</td><td>${m.role}</td><td>
                <button data-id="${m.id}" class="btn btn-secondary btn-edit">Edit</button>
                <button data-id="${m.id}" class="btn btn-danger btn-delete">Hapus</button>
            </td>`;
            tbody.appendChild(tr);
        });
        document.querySelectorAll('.btn-delete').forEach(b=>b.addEventListener('click', async e=>{
            if (!confirm('Hapus member ini?')) return;
            const id = e.target.dataset.id;
            const form = new FormData(); form.append('action','delete'); form.append('id',id);
            const r = await fetch('/admin/members',{method:'POST',body:form, credentials: 'same-origin'}); const jr = await r.json();
            if (typeof notify === 'function') notify(jr.message || 'Selesai', jr.success ? 'success' : 'error'); else alert(jr.message || 'Selesai');
            loadMembers();
        }));
    }

    document.getElementById('createMemberForm').addEventListener('submit', async (e)=>{
        e.preventDefault();
        const f = new FormData(e.target); f.append('action','create');
        const r = await fetch('/admin/members',{method:'POST',body:f, credentials: 'same-origin'}); const jr = await r.json();
        document.getElementById('createMsg').textContent = jr.message || '';
        if (jr.success) { e.target.reset(); loadMembers(); }
    });

    loadMembers();
    </script>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>
</html>
