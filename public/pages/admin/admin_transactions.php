<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login('admin');

$stmt = $pdo->query('SELECT wt.*, u.full_name FROM waste_transactions wt JOIN users u ON wt.user_id = u.id WHERE wt.status = "pending" ORDER BY wt.created_at ASC');
$txs = $stmt->fetchAll();

// pickup summary counts for admin dashboard
$countsStmt = $pdo->query("SELECT status, COUNT(*) as c FROM pickups GROUP BY status");
$countsRaw = $countsStmt->fetchAll();
$pickupCounts = ['pending'=>0,'scheduled'=>0,'completed'=>0,'cancelled'=>0];
foreach ($countsRaw as $r) { $pickupCounts[$r['status']] = (int)$r['c']; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Verifikasi Transaksi</title>
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
        <div style="display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;">
            <a href="/admin/pickups?status=pending" class="card">
                <div class="card-title">Menunggu</div>
                <div class="card-value"><?= (int)$pickupCounts['pending'] ?></div>
            </a>
            <a href="/admin/pickups?status=scheduled" class="card">
                <div class="card-title">Dijadwalkan</div>
                <div class="card-value"><?= (int)$pickupCounts['scheduled'] ?></div>
            </a>
            <a href="/admin/pickups?status=completed" class="card">
                <div class="card-title">Selesai</div>
                <div class="card-value"><?= (int)$pickupCounts['completed'] ?></div>
            </a>
            <a href="/admin/pickups?status=cancelled" class="card">
                <div class="card-title">Dibatalkan</div>
                <div class="card-value"><?= (int)$pickupCounts['cancelled'] ?></div>
            </a>
        </div>
        <h1>Transaksi Pending</h1>
        <?php if (!$txs): ?>
            <p>Tidak ada transaksi pending.</p>
        <?php else: ?>
            <?php foreach ($txs as $t): ?>
                <div class="tx-card">
                    <div><strong>#<?= (int)$t['id'] ?></strong> — <?= htmlspecialchars($t['created_at']) ?> — <em><?= htmlspecialchars($t['full_name']) ?></em></div>
                    <div>Berat: <?= htmlspecialchars($t['total_weight']) ?> kg | Harga: Rp <?= number_format($t['total_price'],0,',','.') ?> | Poin: <?= number_format($t['total_points']) ?></div>
                    <div style="margin-top:10px;">
                        <button data-approve-btn data-tx-id="<?= (int)$t['id'] ?>" data-action="approve" class="btn btn-primary">Setujui</button>
                        <button data-approve-btn data-tx-id="<?= (int)$t['id'] ?>" data-action="reject" class="btn btn-secondary">Tolak</button>
                        <a href="/transactions?tx=<?= (int)$t['id'] ?>" class="btn">Lihat detail</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>
</html>
