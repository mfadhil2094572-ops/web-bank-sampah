<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();
$stmt = $pdo->prepare('SELECT cash_balance, total_points FROM wallets WHERE user_id = ?');
$stmt->execute([$user['id']]);
$wallet = $stmt->fetch() ?: ['cash_balance' => 0, 'total_points' => 0];
$stmt = $pdo->prepare('SELECT IFNULL(SUM(total_weight),0) as total_w, COUNT(*) as tx_count FROM waste_transactions WHERE user_id = ? AND status = "approved"');
$stmt->execute([$user['id']]);
$stats = $stmt->fetch();
$totalWaste = $stats['total_w'] ?? 0;
$txCount = $stats['tx_count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Member - Bank Sampah</title>
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

    <!-- Main Content -->
    <main class="main-content">
            <div class="page-header">
                <div>
                    <h1>Selamat Datang, <span id="welcomeName"><?= htmlspecialchars($user['full_name']) ?></span>!</h1>
                    <p>Pantau aktivitas sampah dan poin reward Anda</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="document.location='/my-waste'">
                        <i class="fas fa-plus"></i> Lapor Sampah
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-box stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Poin</h3>
                        <p class="stat-value" id="totalPoints"><?= number_format($wallet['total_points']) ?></p>
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Saldo Tunai</h3>
                        <p class="stat-value" id="cashBalance">Rp <?= number_format($wallet['cash_balance'],0,',','.') ?></p>
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #dc2626);">
                        <i class="fas fa-trash"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Sampah</h3>
                        <p class="stat-value" id="totalWaste"><?= htmlspecialchars($totalWaste) ?> kg</p>
                    </div>
                </div>

                <div class="stat-box">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Transaksi</h3>
                        <p class="stat-value" id="totalTransactions"><?= htmlspecialchars($txCount) ?></p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-card">
                    <h3><i class="fas fa-chart-pie"></i> Jenis Sampah Terkumpul</h3>
                    <div class="chart-container">
                        <div class="pie-chart" id="wasteChart">
                            <svg viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="#22c55e" opacity="0.3"></circle>
                                <circle cx="50" cy="50" r="35"></circle>
                            </svg>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <span class="legend-color" style="background: #22c55e;"></span>
                                <span>Plastik (40%)</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background: #3b82f6;"></span>
                                <span>Kertas (25%)</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background: #f59e0b;"></span>
                                <span>Logam (20%)</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-color" style="background: #8b5cf6;"></span>
                                <span>Lainnya (15%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <h3><i class="fas fa-chart-line"></i> Grafik Poin Per Bulan</h3>
                    <div class="chart-container">
                        <div class="bar-chart">
                            <div class="bar" style="height: 30%;"><span>300</span></div>
                            <div class="bar" style="height: 50%;"><span>500</span></div>
                            <div class="bar" style="height: 70%;"><span>700</span></div>
                            <div class="bar" style="height: 45%;"><span>450</span></div>
                            <div class="bar" style="height: 80%;"><span>800</span></div>
                            <div class="bar" style="height: 60%;"><span>600</span></div>
                        </div>
                        <div class="months">
                            <span>Jan</span>
                            <span>Feb</span>
                            <span>Mar</span>
                            <span>Apr</span>
                            <span>Mei</span>
                            <span>Jun</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="activity-section">
                <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon" style="background: #22c55e;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Sampah Plastik Diterima</h4>
                            <p>2 kg plastik | +200 poin</p>
                            <small>2 hari yang lalu</small>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #3b82f6;">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Poin Ditukar dengan Uang</h4>
                            <p>500 poin → Rp 50.000</p>
                            <small>1 minggu yang lalu</small>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #f59e0b;">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Layanan Jemput Selesai</h4>
                            <p>5 kg sampah campuran</p>
                            <small>2 minggu yang lalu</small>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background: #8b5cf6;">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="activity-content">
                            <h4>Reward Diterima</h4>
                            <p>Voucher Indomaret Rp 100.000</p>
                            <small>1 bulan yang lalu</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="/my-waste" class="action-card">
                    <i class="fas fa-plus-circle"></i>
                    <h4>Lapor Sampah</h4>
                    <p>Laporkan sampah baru</p>
                </a>
                <a href="/pickup" class="action-card">
                    <i class="fas fa-truck-pickup"></i>
                    <h4>Pesan Jemput</h4>
                    <p>Panggil layanan jemput</p>
                </a>
                <a href="/rewards" class="action-card">
                    <i class="fas fa-award"></i>
                    <h4>Tukar Reward</h4>
                    <p>Lihat hadiah menarik</p>
                </a>
                <a href="/transactions" class="action-card">
                    <i class="fas fa-receipt"></i>
                    <h4>Riwayat</h4>
                    <p>Lihat semua transaksi</p>
                </a>
            </div>
        </main>
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
</body>
</html>
