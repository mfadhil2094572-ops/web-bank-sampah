<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login('admin');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Kelola Jenis Sampah</title>
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
                    <a href="#"><i class="fas fa-user-circle"></i> <span id="userName"><?= htmlspecialchars($user['full_name']) ?></span></a>
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
        <h1>Kelola Jenis & Harga Sampah</h1>

        <section style="margin-bottom:20px;">
            <h3>Tambah Jenis Sampah</h3>
            <form id="createTypeForm">
                <input name="name" placeholder="Nama jenis" required>
                <input name="price_per_kg" type="number" placeholder="Harga per kg" required>
                <input name="point_per_kg" type="number" placeholder="Poin per kg" required>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
            <div id="createMsg"></div>
        </section>

        <section>
            <h3>Daftar Jenis</h3>
            <table id="typesTable" class="table">
                <thead><tr><th>ID</th><th>Nama</th><th>Harga/kg</th><th>Poin/kg</th><th>Aksi</th></tr></thead>
                <tbody></tbody>
            </table>
        </section>
    </div>

    <script>
    async function loadTypes(){
        const res = await fetch('/admin/waste_types.php', {credentials: 'same-origin'});
        const data = await res.json();
        const tbody = document.querySelector('#typesTable tbody');
        tbody.innerHTML = '';
        if (!data.success) return;
        data.data.forEach(m => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${m.id}</td><td>${m.name}</td><td>${m.price_per_kg}</td><td>${m.point_per_kg}</td><td>
                <button data-id="${m.id}" class="btn btn-secondary btn-edit">Edit</button>
                <button data-id="${m.id}" class="btn btn-danger btn-delete">Hapus</button>
            </td>`;
            tbody.appendChild(tr);
        });
        document.querySelectorAll('.btn-delete').forEach(b=>b.addEventListener('click', async e=>{
            if (!confirm('Hapus jenis sampah ini?')) return;
            const id = e.target.dataset.id;
            const form = new FormData(); form.append('action','delete'); form.append('id',id);
            const r = await fetch('/admin/waste_types.php',{method:'POST',body:form, credentials: 'same-origin'}); const jr = await r.json();
            if (typeof notify === 'function') notify(jr.message || 'Selesai', jr.success ? 'success' : 'error'); else alert(jr.message || 'Selesai');
            loadTypes();
        }));
    }

    document.getElementById('createTypeForm').addEventListener('submit', async (e)=>{
        e.preventDefault();
        const f = new FormData(e.target); f.append('action','create');
        const r = await fetch('/admin/waste_types.php',{method:'POST',body:f, credentials: 'same-origin'}); const jr = await r.json();
        document.getElementById('createMsg').textContent = jr.message || '';
        if (jr.success) { e.target.reset(); loadTypes(); }
    });

    loadTypes();
    </script>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>
</html>
