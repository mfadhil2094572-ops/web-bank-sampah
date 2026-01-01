<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login();
$user = bs_get_current_user();

$txId = isset($_GET['tx']) ? intval($_GET['tx']) : 0;
if ($txId) {
	$stmt = $pdo->prepare('SELECT * FROM waste_transactions WHERE id = ? AND user_id = ?');
	$stmt->execute([$txId, $user['id']]);
	$tx = $stmt->fetch();
	if (!$tx) {
		http_response_code(404);
		echo 'Transaksi tidak ditemukan';
		exit;
	}
	$stmt = $pdo->prepare('SELECT wti.*, wt.name as waste_name FROM waste_transaction_items wti JOIN waste_types wt ON wti.waste_type_id = wt.id WHERE wti.transaction_id = ?');
	$stmt->execute([$txId]);
	$items = $stmt->fetchAll();
} else {
	$stmt = $pdo->prepare('SELECT id, total_weight, total_price, total_points, status, created_at FROM waste_transactions WHERE user_id = ? ORDER BY created_at DESC');
	$stmt->execute([$user['id']]);
	$txs = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Riwayat Transaksi - Bank Sampah</title>
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/dashboard.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
	<nav class="navbar">
		<div class="navbar-container">
			<div class="navbar-logo"><i class="fas fa-leaf"></i><span>Bank Sampah</span></div>
			<ul class="nav-menu" id="navMenu">
				<li><a href="/">Beranda</a></li>
				<li><a href="/dashboard">Dashboard</a></li>
				<li><a href="#" onclick="logout()" class="btn-login">Keluar</a></li>
			</ul>
		</div>
	</nav>

	<div class="dashboard-container">
		<aside class="sidebar">
			<div class="sidebar-header"><h3>Menu</h3></div>
			<nav class="sidebar-nav">
				<a href="/dashboard" class="nav-item"><i class="fas fa-home"></i><span>Dashboard</span></a>
				<a href="/my-waste" class="nav-item"><i class="fas fa-trash"></i><span>Sampah Saya</span></a>
				<a href="/transactions" class="nav-item active"><i class="fas fa-exchange-alt"></i><span>Transaksi</span></a>
				<a href="/rewards" class="nav-item"><i class="fas fa-gift"></i><span>Reward</span></a>
				<?php if (($user['role'] ?? '') === 'admin'): ?>
				<div class="sidebar-section">
					<div class="sidebar-section-title">Manajemen <button class="manajemen-toggle" aria-label="Toggle Manajemen">▾</button></div>
					<nav class="sidebar-subnav">
						<a href="/admin/transactions" class="nav-item"><i class="fas fa-check-circle"></i><span>Kelola Laporan</span></a>
						<a href="/admin/pickups" class="nav-item"><i class="fas fa-truck"></i><span>Kelola Penjemputan</span></a>
						<a href="/admin/members" class="nav-item"><i class="fas fa-users"></i><span>Anggota</span></a>
					</nav>
				</div>
				<?php endif; ?>
				<a href="/profile" class="nav-item"><i class="fas fa-user"></i><span>Profil</span></a>
				<a href="#" onclick="logout()" class="nav-item logout"><i class="fas fa-sign-out-alt"></i><span>Keluar</span></a>
			</nav>
		</aside>

		<main class="main-content">
			<div class="page-header">
				<h1>Riwayat Transaksi</h1>
				<p>Pantau semua transaksi sampah Anda</p>
			</div>

			<?php if ($txId): ?>
				<div class="transaction-detail">
					<h2>Transaksi #<?= (int)$tx['id'] ?> — <?= htmlspecialchars($tx['status']) ?></h2>
					<p>Tanggal: <?= htmlspecialchars($tx['created_at']) ?></p>
					<div class="transaction-table">
						<table>
							<thead>
								<tr><th>Jenis</th><th>Berat</th><th>Harga</th><th>Poin</th></tr>
							</thead>
							<tbody>
								<?php foreach ($items as $it): ?>
									<tr>
										<td><?= htmlspecialchars($it['waste_name']) ?></td>
										<td><?= htmlspecialchars($it['weight']) ?> kg</td>
										<td>Rp <?= number_format($it['price'],0,',','.') ?></td>
										<td><?= number_format($it['points']) ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div style="margin-top:15px;">
						<strong>Total Berat:</strong> <?= htmlspecialchars($tx['total_weight']) ?> kg<br>
						<strong>Total Harga:</strong> Rp <?= number_format($tx['total_price'],0,',','.') ?><br>
						<strong>Total Poin:</strong> <?= number_format($tx['total_points']) ?><br>
					</div>
				</div>
				<p><a href="/transactions">Kembali ke daftar</a></p>
			<?php else: ?>
				<?php if (empty($txs)): ?>
					<p>Belum ada transaksi.</p>
				<?php else: ?>
					<div class="transaction-table">
						<table>
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Berat</th>
									<th>Nilai</th>
									<th>Poin</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($txs as $t): ?>
									<tr>
										<td><?= htmlspecialchars($t['created_at']) ?></td>
										<td><?= htmlspecialchars($t['total_weight']) ?> kg</td>
										<td>Rp <?= number_format($t['total_price'],0,',','.') ?></td>
										<td><?= number_format($t['total_points']) ?></td>
										<td><?= htmlspecialchars($t['status']) ?></td>
										<td><a class="btn" href="/transactions?tx=<?= (int)$t['id'] ?>">Detail</a></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				<?php endif; ?>
			<?php endif; ?>

		</main>
	</div>
	<div class="sidebar-backdrop" onclick="document.querySelector('.sidebar') && document.querySelector('.sidebar').classList.remove('open'); document.body.style.overflow='';"></div>

	<footer class="footer"><div class="container"><div class="footer-bottom"><p>&copy; 2024 Bank Sampah Indonesia.</p></div></div></footer>

	<script src="/assets/js/script.js"></script>
	<script src="/assets/js/dashboard.js"></script>
	<style>
		.transaction-table { background: white; border-radius: 12px; padding: 20px; box-shadow: var(--shadow); overflow-x: auto; }
		.transaction-table table { width: 100%; border-collapse: collapse; }
		.transaction-table th { background: var(--primary-color); color: white; padding: 15px; text-align: left; }
		.transaction-table td { padding: 15px; border-bottom: 1px solid var(--border-color); }
		.transaction-table tr:hover { background: var(--light-color); }
		.badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
		.badge-approved { background: #d1fae5; color: #065f46; }
	</style>
</body>
</html>


