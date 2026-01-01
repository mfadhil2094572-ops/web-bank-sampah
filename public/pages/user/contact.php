<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Bank Sampah</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
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
                <li><a href="/members">Member</a></li>
                <li><a href="/contact" class="active">Kontak</a></li>
                <li><a href="/login" class="btn-login">Masuk</a></li>
            </ul>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="contact-header">
        <div class="container">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda dengan pertanyaan atau masukan apapun</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-wrapper">
                <!-- Contact Info -->
                <div class="contact-info">
                    <h2>Informasi Kontak</h2>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h3>Alamat Kantor</h3>
                            <p>Jl. Gatot Subroto No. 42<br>Jakarta Selatan 12345<br>Indonesia</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h3>Telepon</h3>
                            <p>(021) 1234-5678<br>+62 812-3456-7890<br>Jam: 08:00 - 18:00 WIB</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h3>Email</h3>
                            <p>info@banksampah.id<br>support@banksampah.id<br>partnership@banksampah.id</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <h3>Jam Operasional</h3>
                            <p>Senin - Jumat: 08:00 - 18:00<br>Sabtu: 08:00 - 16:00<br>Minggu: Tutup</p>
                        </div>
                    </div>

                    <div class="social-links-contact">
                        <h3>Ikuti Kami</h3>
                        <div class="social-icons">
                            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2>Kirim Pesan</h2>
                    <form class="contact-form" id="contactForm">
                        <div class="form-group">
                            <label for="contactName">Nama Lengkap</label>
                            <input type="text" id="contactName" name="name" placeholder="Nama Anda" required>
                        </div>

                        <div class="form-group">
                            <label for="contactEmail">Email</label>
                            <input type="email" id="contactEmail" name="email" placeholder="Email Anda" required>
                        </div>

                        <div class="form-group">
                            <label for="contactPhone">Nomor Telepon</label>
                            <input type="tel" id="contactPhone" name="phone" placeholder="0812-3456-7890">
                        </div>

                        <div class="form-group">
                            <label for="contactSubject">Subjek</label>
                            <select id="contactSubject" name="subject" required>
                                <option value="">-- Pilih Subjek --</option>
                                <option value="pertanyaan">Pertanyaan Umum</option>
                                <option value="keluhan">Keluhan/Saran</option>
                                <option value="partnership">Kerjasama Bisnis</option>
                                <option value="media">Media & Press</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contactMessage">Pesan</label>
                            <textarea id="contactMessage" name="message" placeholder="Tulis pesan Anda di sini..." rows="6" required></textarea>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" id="agreePrivacy" name="agreePrivacy" required>
                            <label for="agreePrivacy">Saya setuju dengan <a href="#">Kebijakan Privasi</a></label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-send">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Map Section -->
            <div class="map-section">
                <h2>Lokasi Kami</h2>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4019949881496!2d106.78881141408838!3d-6.265531462181818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f40a39d9e0ad%3A0xd9c2f97c6f5e0a0!2sJakarta%20Selatan!5e0!3m2!1sen!2sid!4v1234567890" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- Offices Section -->
    <section class="offices-section">
        <div class="container">
            <h2>Cabang Kami di Seluruh Indonesia</h2>
            <p class="section-subtitle">Kami tersebar di berbagai kota untuk melayani Anda lebih baik</p>

            <div class="offices-grid">
                <div class="office-card">
                    <h3>Jakarta</h3>
                    <p><strong>Alamat:</strong><br>Jl. Gatot Subroto No. 42</p>
                    <p><strong>Telepon:</strong><br>(021) 1234-5678</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>

                <div class="office-card">
                    <h3>Surabaya</h3>
                    <p><strong>Alamat:</strong><br>Jl. Ahmad Yani No. 100</p>
                    <p><strong>Telepon:</strong><br>(031) 5678-9012</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>

                <div class="office-card">
                    <h3>Bandung</h3>
                    <p><strong>Alamat:</strong><br>Jl. Diponegoro No. 50</p>
                    <p><strong>Telepon:</strong><br>(022) 2345-6789</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>

                <div class="office-card">
                    <h3>Medan</h3>
                    <p><strong>Alamat:</strong><br>Jl. Merdeka No. 200</p>
                    <p><strong>Telepon:</strong><br>(061) 9012-3456</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>

                <div class="office-card">
                    <h3>Yogyakarta</h3>
                    <p><strong>Alamat:</strong><br>Jl. Malioboro No. 150</p>
                    <p><strong>Telepon:</strong><br>(0274) 3456-7890</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>

                <div class="office-card">
                    <h3>Makassar</h3>
                    <p><strong>Alamat:</strong><br>Jl. Sultan Hasanuddin No. 80</p>
                    <p><strong>Telepon:</strong><br>(0411) 5678-9012</p>
                    <p><strong>Jam Buka:</strong><br>08:00 - 18:00</p>
                </div>
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
                        <li><a href="about.html">Tentang Kami</a></li>
                        <li><a href="services.html">Layanan</a></li>
                        <li><a href="members.html">Member</a></li>
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

    <script src="../js/script.js"></script>
    <script>
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = document.getElementById('contactName').value;
            const email = document.getElementById('contactEmail').value;
            const subject = document.getElementById('contactSubject').value;

            if (!name || !email || !subject) {
                alert('Silakan isi semua field yang diperlukan!');
                return;
            }

            alert('Terima kasih telah menghubungi kami! Kami akan merespon pesan Anda secepatnya.');
            contactForm.reset();
        });
    </script>
    <style>
        .contact-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .contact-header h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .contact-header p {
            font-size: 18px;
            opacity: 0.9;
        }

        .contact-section {
            padding: 60px 20px;
        }

        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }

        .contact-info h2,
        .contact-form-wrapper h2 {
            font-size: 28px;
            color: var(--dark-color);
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            flex-shrink: 0;
        }

        .info-content h3 {
            color: var(--dark-color);
            margin-bottom: 10px;
            margin-top: 0;
        }

        .info-content p {
            color: var(--text-color);
            margin: 0;
            line-height: 1.8;
        }

        .social-links-contact {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid var(--border-color);
        }

        .social-links-contact h3 {
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contact-form .form-group {
            display: flex;
            flex-direction: column;
        }

        .contact-form label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            padding: 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: #f0fdf4;
        }

        .contact-form .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-form .form-check input {
            width: auto;
        }

        .contact-form .btn-send {
            width: 100%;
            padding: 14px;
        }

        .map-section {
            margin-bottom: 80px;
        }

        .map-section h2 {
            font-size: 28px;
            color: var(--dark-color);
            margin-bottom: 25px;
        }

        .map-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .offices-section {
            background-color: var(--light-color);
            padding: 60px 20px;
        }

        .offices-section h2 {
            text-align: center;
            color: var(--dark-color);
            font-size: 36px;
            margin-bottom: 50px;
        }

        .offices-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .office-card {
            background-color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .office-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .office-card h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 20px;
        }

        .office-card p {
            color: var(--text-color);
            margin-bottom: 12px;
            line-height: 1.8;
        }

        .office-card p strong {
            color: var(--dark-color);
        }

        @media (max-width: 768px) {
            .contact-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .map-container iframe {
                height: 300px;
            }

            .contact-header h1 {
                font-size: 28px;
            }

            .offices-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
