<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member - Bank Sampah</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/pages.css">
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
                <li><a href="/about">Tentang Kami</a></li>
                <li><a href="/services">Layanan</a></li>
                <li><a href="/members" class="active">Member</a></li>
                <li><a href="/contact">Kontak</a></li>
                <li><a href="/login" class="btn-login">Masuk</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Komunitas Member</h1>
            <p>Bergabunglah dengan ribuan anggota yang peduli lingkungan</p>
        </div>
    </section>

    <!-- Member Stats -->
    <section class="member-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>15,000+</h3>
                    <p>Member Aktif</p>
                </div>
                <div class="stat-card">
                    <h3>500 Kota</h3>
                    <p>Jangkauan Nasional</p>
                </div>
                <div class="stat-card">
                    <h3>Rp 500 Juta+</h3>
                    <p>Uang Terdistribusi</p>
                </div>
                <div class="stat-card">
                    <h3>5,000 Ton</h3>
                    <p>Sampah Terkumpul</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Member Benefits -->
    <section class="member-benefits">
        <div class="container">
            <h2>Keuntungan Menjadi Member</h2>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <h3>Penghasilan Tambahan</h3>
                    <p>Dapatkan uang tunai setiap kali menyerahkan sampah. Tidak ada batasan minimum.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3>Sistem Poin Fleksibel</h3>
                    <p>Kumpulkan poin dan tukarkan kapan saja dengan hadiah menarik atau uang.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>Layanan Jemput Gratis</h3>
                    <p>Layanan pickup langsung dari rumah atau kantor Anda tanpa biaya tambahan.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Pelatihan Gratis</h3>
                    <p>Ikuti workshop dan seminar tentang pengurangan sampah dan bisnis daur ulang.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Dashboard Digital</h3>
                    <p>Pantau progress, riwayat transaksi, dan poin reward secara real-time.</p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Komunitas Aktif</h3>
                    <p>Bergabung dengan komunitas yang peduli lingkungan dan saling berbagi pengalaman.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Tiers -->
    <section class="membership-tiers">
        <div class="container">
            <h2>Tingkatan Membership</h2>
            <p class="section-subtitle">Semakin aktif Anda, semakin banyak keuntungan yang Anda dapatkan</p>

            <div class="tiers-grid">
                <div class="tier-card">
                    <div class="tier-badge">Bronze</div>
                    <h3>Bronze Member</h3>
                    <p class="tier-requirement">0 - 5000 Poin</p>
                    <ul class="tier-features">
                        <li><i class="fas fa-check"></i> Diskon 5% tukar poin</li>
                        <li><i class="fas fa-check"></i> Priority support</li>
                        <li><i class="fas fa-check"></i> Akses ke workshop</li>
                    </ul>
                    <button class="btn btn-secondary">Mulai</button>
                </div>

                <div class="tier-card featured">
                    <div class="tier-badge silver">Silver</div>
                    <h3>Silver Member</h3>
                    <p class="tier-requirement">5000 - 15000 Poin</p>
                    <ul class="tier-features">
                        <li><i class="fas fa-check"></i> Diskon 10% tukar poin</li>
                        <li><i class="fas fa-check"></i> VIP support 24/7</li>
                        <li><i class="fas fa-check"></i> Akses early bird promo</li>
                        <li><i class="fas fa-check"></i> Bonus poin 5%</li>
                    </ul>
                    <button class="btn btn-primary">Upgrade</button>
                </div>

                <div class="tier-card">
                    <div class="tier-badge gold">Gold</div>
                    <h3>Gold Member</h3>
                    <p class="tier-requirement">15000+ Poin</p>
                    <ul class="tier-features">
                        <li><i class="fas fa-check"></i> Diskon 15% tukar poin</li>
                        <li><i class="fas fa-check"></i> Dedicated account manager</li>
                        <li><i class="fas fa-check"></i> Akses all exclusive events</li>
                        <li><i class="fas fa-check"></i> Bonus poin 10%</li>
                        <li><i class="fas fa-check"></i> Free shipping jemput</li>
                    </ul>
                    <button class="btn btn-primary">Upgrade</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section class="success-stories">
        <div class="container">
            <h2>Kisah Sukses Member</h2>
            <div class="stories-grid">
                <div class="story-card">
                    <div class="story-image">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Ibu Slamet</h3>
                    <p class="story-subtitle">Member sejak Januari 2021</p>
                    <p class="story-text">"Awalnya saya hanya ingin mengurangi sampah rumah. Tapi sekarang Bank Sampah jadi sumber penghasilan utama saya. Dalam setahun sudah dapat Rp 2 juta!"</p>
                    <div class="story-stats">
                        <div>Rp 2 Juta</div>
                        <div>Earning</div>
                    </div>
                </div>

                <div class="story-card">
                    <div class="story-image">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Ahmad Ridho</h3>
                    <p class="story-subtitle">Member sejak Mei 2022</p>
                    <p class="story-text">"Saya mengajak anak-anak saya untuk mengumpulkan sampah. Ini cara yang bagus untuk mengajarkan mereka tentang lingkungan dan mendapat uang saku."</p>
                    <div class="story-stats">
                        <div>Rp 1.5 Juta</div>
                        <div>Earning</div>
                    </div>
                </div>

                <div class="story-card">
                    <div class="story-image">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Dewi Kusuma</h3>
                    <p class="story-subtitle">Member sejak Oktober 2021</p>
                    <p class="story-text">"Sekarang saya dan komunitas di RT saya berkumpul setiap minggu mengumpulkan sampah. Kami berbagi earning dan sebagian untuk program CSR lokal."</p>
                    <div class="story-stats">
                        <div>Rp 3 Juta</div>
                        <div>Group Earning</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap Bergabung?</h2>
            <p>Mulai perjalanan Anda menuju hidup yang lebih berkelanjutan dan menguntungkan</p>
            <div class="cta-buttons">
                <a href="/login" class="btn btn-primary">Daftar Sekarang</a>
                <a href="/services" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>Tentang Bank Sampah</h4>
                    <p>Mengubah sampah menjadi sumber daya berharga untuk masa depan berkelanjutan.</p>
                </div>
                <div class="footer-section">
                    <h4>Tautan Cepat</h4>
                    <ul>
                        <li><a href="/about">Tentang Kami</a></li>
                        <li><a href="/services">Layanan</a></li>
                        <li><a href="/contact">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <p>
                        <i class="fas fa-phone"></i> +62 XXX-XXXX-XXXX<br>
                        <i class="fas fa-envelope"></i> info@banksampah.id
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Bank Sampah Indonesia. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/script.js"></script>
    <style>
        .member-benefits {
            padding: 60px 20px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .benefit-card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .benefit-icon {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .benefit-card h3 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .benefit-card p {
            color: var(--text-color);
            margin: 0;
        }

        .membership-tiers {
            background-color: var(--light-color);
            padding: 60px 20px;
        }

        .membership-tiers h2 {
            text-align: center;
            color: var(--dark-color);
            font-size: 36px;
            margin-bottom: 50px;
        }

        .tiers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .tier-card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: var(--shadow);
            position: relative;
            transition: all 0.3s ease;
        }

        .tier-card.featured {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .tier-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .tier-badge {
            position: absolute;
            top: -15px;
            right: 20px;
            background-color: #8b5cf6;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .tier-badge.silver {
            background-color: #a8a8a8;
        }

        .tier-badge.gold {
            background-color: #fbbf24;
            color: #1f2937;
        }

        .tier-card h3 {
            color: var(--dark-color);
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .tier-requirement {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .tier-features {
            list-style: none;
            margin: 25px 0;
            text-align: left;
        }

        .tier-features li {
            padding: 10px 0;
            color: var(--text-color);
            border-bottom: 1px solid var(--border-color);
        }

        .tier-features li:last-child {
            border-bottom: none;
        }

        .tier-features i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        .tier-card .btn {
            width: 100%;
            margin-top: 20px;
        }

        .success-stories {
            padding: 60px 20px;
        }

        .success-stories h2 {
            text-align: center;
            color: var(--dark-color);
            font-size: 36px;
            margin-bottom: 50px;
        }

        .stories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .story-card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: all 0.3s ease;
        }

        .story-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .story-image {
            font-size: 80px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .story-card h3 {
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .story-subtitle {
            color: var(--text-color);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .story-text {
            color: var(--text-color);
            margin-bottom: 20px;
            font-style: italic;
        }

        .story-stats {
            background-color: var(--light-color);
            padding: 15px;
            border-radius: 8px;
        }

        .story-stats div:first-child {
            color: var(--primary-color);
            font-size: 20px;
            font-weight: 600;
        }

        .story-stats div:last-child {
            color: var(--text-color);
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .tier-card.featured {
                transform: scale(1);
            }

            .tiers-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-buttons .btn {
                width: 100%;
            }
        }
    </style>
</body>
</html>
