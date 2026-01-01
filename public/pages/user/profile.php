<?php
require_once __DIR__ . '/../../../app/middleware/auth.php';
require_login();
$me = bs_get_current_user();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Dashboard Bank Sampah</title>
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
                <a href="/transactions" class="nav-item"><i class="fas fa-exchange-alt"></i><span>Transaksi</span></a>
                <a href="/rewards" class="nav-item"><i class="fas fa-gift"></i><span>Reward</span></a>
                <?php if (($me['role'] ?? '') === 'admin'): ?>
                <div class="sidebar-section">
                    <div class="sidebar-section-title">Manajemen <button class="manajemen-toggle" aria-label="Toggle Manajemen">▾</button></div>
                    <nav class="sidebar-subnav">
                        <a href="/admin/transactions" class="nav-item"><i class="fas fa-check-circle"></i><span>Kelola Laporan</span></a>
                        <a href="/admin/pickups" class="nav-item"><i class="fas fa-truck"></i><span>Kelola Penjemputan</span></a>
                        <a href="/admin/members" class="nav-item"><i class="fas fa-users"></i><span>Anggota</span></a>
                    </nav>
                </div>
                <?php endif; ?>
                <a href="/profile" class="nav-item active"><i class="fas fa-user"></i><span>Profil</span></a>
                <a href="#" onclick="logout()" class="nav-item logout"><i class="fas fa-sign-out-alt"></i><span>Keluar</span></a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>Profil Saya</h1>
                <p>Kelola informasi pribadi Anda</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: var(--shadow);">
                    <h3>Informasi Pribadi</h3>
                    <?php if (!empty($_GET['success'])): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                    <?php elseif (!empty($_GET['error'])): ?>
                        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php endif; ?>

                    <form class="form" method="post" action="/api/user/profile_update.php">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="full_name" value="<?php echo htmlspecialchars($me['full_name'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo htmlspecialchars($me['email'] ?? ''); ?>" disabled style="background: var(--light-color);">
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($me['phone'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" rows="3"><?php echo htmlspecialchars($me['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" name="city" value="<?php echo htmlspecialchars($me['city'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Perubahan</button>
                    </form>
                </div>

                <div>
                    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: var(--shadow); margin-bottom: 20px;">
                        <h3>Statistik Saya</h3>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div style="display: flex; justify-content: space-between; padding: 15px; background: var(--light-color); border-radius: 8px;">
                                <span>Member Sejak</span>
                                <strong>15 Januari 2023</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 15px; background: var(--light-color); border-radius: 8px;">
                                <span>Total Sampah</span>
                                <strong>50 kg</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 15px; background: var(--light-color); border-radius: 8px;">
                                <span>Transaksi</span>
                                <strong>12 Transaksi</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; padding: 15px; background: var(--light-color); border-radius: 8px;">
                                <span>Total Earning</span>
                                <strong>Rp 425.000</strong>
                            </div>
                        </div>
                    </div>

                    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: var(--shadow);">
                        <h3>Keamanan</h3>
                        <form id="changePasswordForm" class="form" style="margin-bottom:15px;">
                            <div class="form-group">
                                <label>Password Saat Ini</label>
                                <input type="password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-secondary" style="width:100%">Ubah Password</button>
                        </form>

                        <form id="deleteAccountForm" class="form">
                            <div class="form-group">
                                <label>Konfirmasi Hapus Akun (masukkan password)</label>
                                <input type="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-danger" style="width:100%; background:#ef4444; color:white; border:none;">Hapus Akun</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="sidebar-backdrop" onclick="document.querySelector('.sidebar') && document.querySelector('.sidebar').classList.remove('open'); document.body.style.overflow='';"></div>

    <footer class="footer"><div class="container"><div class="footer-bottom"><p>&copy; 2024 Bank Sampah Indonesia.</p></div></div></footer>

    <script src="/assets/js/script.js"></script>
    <script src="/assets/js/dashboard.js"></script>
    <script>
        document.getElementById('changePasswordForm').addEventListener('submit', async function(e){
            e.preventDefault();
            const f = new FormData(e.target);
            const res = await fetch('/api/auth/change_password.php',{method:'POST',body:f, credentials: 'same-origin'});
            const jr = await res.json();
            if (typeof notify === 'function') notify(jr.message || 'Done', jr.success ? 'success' : 'error'); else alert(jr.message || 'Done');
            if (jr.success) e.target.reset();
        });

        document.getElementById('deleteAccountForm').addEventListener('submit', async function(e){
            e.preventDefault();
            if (!confirm('Akun Anda akan dihapus permanen. Lanjutkan?')) return;
            const f = new FormData(e.target);
            const res = await fetch('/api/auth/delete_account.php',{method:'POST',body:f, credentials: 'same-origin'});
            const jr = await res.json();
            if (typeof notify === 'function') notify(jr.message || 'Done', jr.success ? 'success' : 'error'); else alert(jr.message || 'Done');
            if (jr.success) window.location.href = '/';
        });
    </script>
</body>
</html>
