<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login('admin');
$user = bs_get_current_user();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin – Kelola Penjemputan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <div class="page-header">
            <div>
                <h1>Kelola Permintaan Jemput</h1>
                <p>Atur status, jadwal, dan riwayat penjemputan sampah</p>
            </div>
        </div>

        <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php elseif (!empty($_GET['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <!-- FILTER BAR -->
        <div class="card" style="margin-bottom:16px">
            <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center">
                <input id="searchInput" placeholder="Cari nama atau email..." class="input">
                <select id="statusFilter" class="input">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="scheduled">Dijadwalkan</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                <select id="perPageSelect" class="input">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- DATA -->
        <div id="pickupsContainer"></div>
        <div id="pickupsPager" style="margin-top:16px"></div>

    </main>
</div>

<script src="/assets/js/script.js"></script>
<script src="/assets/js/dashboard.js"></script>

</body>
</html>
