````markdown
# 🌍 Bank Sampah Indonesia - Website Lengkap

Website Bank Sampah yang komprehensif dengan fitur-fitur lengkap untuk manajemen sampah, reward system, dan tracking poin anggota.

## ✨ Fitur Utama

### 1. **Beranda (index.php)**
- Hero section yang menarik dengan call-to-action
- Statistik real-time tentang sampah yang terkumpul
- Layanan unggulan dengan deskripsi lengkap
- Cara kerja sistem Bank Sampah
- Jenis sampah yang diterima dengan harga
- Testimonial dari member
- Newsletter subscription
- SEO-friendly structure

### 2. **Autentikasi (pages/login.php)**
- **Login Member**: Email & Password
- **Registrasi Baru**: Formulir lengkap dengan validasi
  - Data pribadi (Nama, Email, Telepon)
  - Alamat (Jalan, Kota, Kode Pos)
  - Keamanan (Password, Konfirmasi)
  - Checkbox syarat & ketentuan
- Toggle password visibility
- Remember me feature
- Form validation real-time

### 3. **Dashboard Member (pages/dashboard.php)**
- **Statistics Widget** dengan card interaktif
  - Total Poin
  - Saldo Tunai
  - Total Sampah Terkumpul
  - Total Transaksi
- **Grafik & Chart**
  - Pie chart jenis sampah
  - Bar chart poin per bulan
- **Activity Feed** dengan timeline
- **Quick Actions** untuk navigasi cepat
- **Sidebar Navigation** dengan multi-level menu
- Protected route (redirect jika belum login)

### 4. **Kalkulator Sampah (pages/calculator.php)**
- Input dinamis untuk berat sampah
- Kalkulasi otomatis harga & poin
- **Fitur Preset** untuk 1kg, 2kg, 5kg, 10kg
- **Shopping Cart System**
  - Tambah/hapus item
  - Summary otomatis
- **Tabel Harga** lengkap semua jenis sampah
- Export/submit hasil kalkulasi

### 5. **Tentang Kami (pages/about.php)**
- Profil perusahaan lengkap
- **Misi & Visi**
- **Nilai Perusahaan** (6 nilai inti)
- **Tim Management** dengan profil
- **Timeline** perjalanan perusahaan
- **Impact Statistics** dampak sosial
- Responsive image gallery

### 6. **Layanan (pages/services.php)**
- Detail 6 layanan utama
- FAQ (Frequently Asked Questions)
- Benefit list untuk setiap layanan
- CTA buttons untuk konversi
- Accordion FAQ yang interaktif

### 7. **Member (pages/members.php)**
- **Member Benefits** showcase
- **Membership Tiers**
  - Bronze (0-5000 Poin)
  - Silver (5000-15000 Poin)
  - Gold (15000+ Poin)
  - Fitur eksklusif per tier
- **Success Stories** dari member nyata
- Member statistics

### 8. **Kontak (pages/contact.php)**
- **Contact Information** lengkap
  - Alamat, Telepon, Email, Jam Operasional
  - Social media links
- **Contact Form** dengan validasi
  - Nama, Email, Telepon, Subjek, Pesan
- **Google Maps Integration** lokasi kantor
- **Office Branches** di 6 kota besar
- Responsive design

## 🛠️ Teknologi

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Responsive design, gradients, animations
- **JavaScript (Vanilla)** - No dependencies required
  - DOM manipulation
  - Local Storage API untuk data persistence
  - Form validation
  - Event handling

### Fitur JavaScript
- **LocalStorage Manager** untuk data member
- **Cart System** untuk kalkulator sampah
- **Modal & Notifications** untuk user feedback
- **Responsive Navigation** dengan hamburger menu
- **Smooth Scrolling** dan transisi
- **Form Validation** dan error handling

## 📁 Struktur File

```
Bank_Sampah/
├── index.php                 # Halaman beranda
├── css/
│   ├── styles.css            # Style utama & responsive
│   ├── auth.css              # Style untuk login/register
│   ├── dashboard.css         # Style dashboard member
│   ├── pages.css             # Style untuk halaman statis
│   └── calculator.css        # Style kalkulator
├── js/
│   ├── script.js             # Script utama & utility
│   ├── auth.js               # Script autentikasi
│   ├── dashboard.js          # Script dashboard
│   └── calculator.js         # Script kalkulator
├── pages/
│   ├── login.php            # Login & Registrasi
│   ├── dashboard.php        # Dashboard member
│   ├── about.php            # Tentang kami
│   ├── services.php         # Layanan detail
│   ├── members.php          # Info member & benefits
│   └── contact.php          # Halaman kontak
└── images/                   # Folder untuk gambar
```

## 🚀 Fitur-Fitur Canggih

### Data Management
- **Local Storage** untuk persistensi data member
  - User profile
  - Waste history
  - Points & rewards
- **Real-time Calculation** untuk sampah

### UI/UX
- **Responsive Design** untuk semua device
- **Mobile-first** approach
- **Smooth Animations** dan transitions
- **Color-coded System** untuk jenis sampah
- **Progress Indicators** dan status badges

### Security
- **Form Validation** client-side
- **Email Format Check**
- **Password Strength Validation** (minimal 8 karakter)
- **Secure Logout** dengan confirmation

### Accessibility
- **Semantic HTML** untuk screen readers
- **ARIA Labels** untuk form fields
- **Keyboard Navigation** support
- **Color Contrast** compliance

## 💾 Data Structure (Local Storage)

### User Data
```javascript
{
  fullName: "Nama Lengkap",
  email: "email@example.com",
  phone: "08123456789",
  address: "Jalan",
  city: "Kota",
  zipCode: "12345",
  registrationDate: "2024-01-01"
}
```

### Waste History
```javascript
{
  id: timestamp,
  date: "1/1/2024",
  items: [
    {
      type: "plastik",
      weight: 2.5,
      price: 8750,
      points: 875
    }
  ],
  totalPrice: 8750,
  totalPoints: 875,
  status: "Selesai"
}
```

### Points Data
```javascript
{
  totalPoints: 2500,
  cashBalance: 250000
}
```

## 📱 Responsive Breakpoints

- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 0px - 767px

## 🎨 Color Scheme

- **Primary**: #22c55e (Green)
- **Secondary**: #16a34a (Dark Green)
- **Dark**: #1f2937 (Dark Gray)
- **Light**: #f3f4f6 (Light Gray)
- **Success**: #10b981
- **Warning**: #f59e0b
- **Danger**: #ef4444

## 🔧 Cara Menggunakan

### 1. Setup Awal
```bash
# Tidak perlu instalasi dependencies
# Cukup buka index.php di browser
```

### 2. Testing Login
- Email apapun (misal: test@example.com)
- Password minimal 8 karakter

### 3. Navigasi
- Click menu di navbar
- Gunakan hamburger menu di mobile
- Quick links tersedia di footer

### 4. Fitur Kalkulator
1. Pilih jenis sampah
2. Masukkan berat
3. Lihat perhitungan otomatis
4. Tambah ke keranjang
5. Submit untuk menyimpan

## 📊 Features Checklist

- ✅ Responsive Design
- ✅ Authentication System
- ✅ Dashboard dengan Statistik
- ✅ Waste Calculator
- ✅ Shopping Cart
- ✅ Local Storage Persistence
- ✅ Form Validation
- ✅ Modal & Notifications
- ✅ FAQ Section
- ✅ Contact Form
- ✅ Multiple Pages (8+ pages)
- ✅ Smooth Animations
- ✅ Mobile Navigation
- ✅ Social Media Links
- ✅ Maps Integration

## 🎯 Best Practices

- Clean & maintainable code
- Semantic HTML structure
- Mobile-first responsive design
- Progressive enhancement
- Performance optimized
- Accessibility compliant

## 📝 Catatan Penting

1. **Untuk Produksi**: Sambungkan dengan backend API
2. **Database**: Gunakan backend untuk persistent storage
3. **Email**: Integrasikan email service untuk notifikasi
4. **Maps**: Ganti embed maps dengan lokasi sebenarnya
5. **Images**: Tambahkan image assets di folder `/images`

## 👨‍💻 Developer Notes

- Semua script vanilla JavaScript (no frameworks)
- CSS modern dengan Grid & Flexbox
- Browser support: Chrome, Firefox, Safari, Edge (modern versions)
- File size minimal dan fast loading
- No external dependencies required

## 📞 Support & Maintenance

Untuk pertanyaan atau perbaikan, silakan hubungi:
- Email: developer@banksampah.id
- Phone: +62-812-XXXX-XXXX

---

**Created**: January 2024
**Version**: 1.0
**License**: MIT

## 🔐 Backend Setup (Quickstart)

1. Import database schema using the provided `bank_sampah.sql` into your MySQL/MariaDB server.

  Using command line:
  ```bash
  mysql -u root -p bank_sampah < bank_sampah.sql
  ```

2. Edit `inc/config.php` and set your database credentials (`db_host`, `db_name`, `db_user`, `db_pass`).

3. (One-time) create an initial admin account:
  ```bash
  php seed_admin.php
  ```
  Remove or protect `seed_admin.php` after use.

4. For local development you can run PHP built-in server (dev only):
  ```bash
  php -S localhost:8000 -t .
  ```
  Then open https://localhost:8000/pages/login.php (set up TLS or use a reverse proxy for HTTPS).

5. For production, host under Apache/Nginx with TLS (Let's Encrypt) and point document root to the project folder.

Security notes:
- Ensure `inc/config.php` is not exposed publicly and has correct permissions.
- Use HTTPS in production.

````
# 🌍 Bank Sampah Indonesia - Website Lengkap

Website Bank Sampah yang komprehensif dengan fitur-fitur lengkap untuk manajemen sampah, reward system, dan tracking poin anggota.

## ✨ Fitur Utama

### 1. **Beranda (index.html)**
- Hero section yang menarik dengan call-to-action
- Statistik real-time tentang sampah yang terkumpul
- Layanan unggulan dengan deskripsi lengkap
- Cara kerja sistem Bank Sampah
- Jenis sampah yang diterima dengan harga
- Testimonial dari member
- Newsletter subscription
- SEO-friendly structure

### 2. **Autentikasi (pages/login.html)**
- **Login Member**: Email & Password
- **Registrasi Baru**: Formulir lengkap dengan validasi
  - Data pribadi (Nama, Email, Telepon)
  - Alamat (Jalan, Kota, Kode Pos)
  - Keamanan (Password, Konfirmasi)
  - Checkbox syarat & ketentuan
- Toggle password visibility
- Remember me feature
- Form validation real-time

### 3. **Dashboard Member (pages/dashboard.html)**
- **Statistics Widget** dengan card interaktif
  - Total Poin
  - Saldo Tunai
  - Total Sampah Terkumpul
  - Total Transaksi
- **Grafik & Chart**
  - Pie chart jenis sampah
  - Bar chart poin per bulan
- **Activity Feed** dengan timeline
- **Quick Actions** untuk navigasi cepat
- **Sidebar Navigation** dengan multi-level menu
- Protected route (redirect jika belum login)

### 4. **Kalkulator Sampah (pages/calculator.html)**
- Input dinamis untuk berat sampah
- Kalkulasi otomatis harga & poin
- **Fitur Preset** untuk 1kg, 2kg, 5kg, 10kg
- **Shopping Cart System**
  - Tambah/hapus item
  - Summary otomatis
- **Tabel Harga** lengkap semua jenis sampah
- Export/submit hasil kalkulasi

### 5. **Tentang Kami (pages/about.html)**
- Profil perusahaan lengkap
- **Misi & Visi**
- **Nilai Perusahaan** (6 nilai inti)
- **Tim Management** dengan profil
- **Timeline** perjalanan perusahaan
- **Impact Statistics** dampak sosial
- Responsive image gallery

### 6. **Layanan (pages/services.html)**
- Detail 6 layanan utama
- FAQ (Frequently Asked Questions)
- Benefit list untuk setiap layanan
- CTA buttons untuk konversi
- Accordion FAQ yang interaktif

### 7. **Member (pages/members.html)**
- **Member Benefits** showcase
- **Membership Tiers**
  - Bronze (0-5000 Poin)
  - Silver (5000-15000 Poin)
  - Gold (15000+ Poin)
  - Fitur eksklusif per tier
- **Success Stories** dari member nyata
- Member statistics

### 8. **Kontak (pages/contact.html)**
- **Contact Information** lengkap
  - Alamat, Telepon, Email, Jam Operasional
  - Social media links
- **Contact Form** dengan validasi
  - Nama, Email, Telepon, Subjek, Pesan
- **Google Maps Integration** lokasi kantor
- **Office Branches** di 6 kota besar
- Responsive design

## 🛠️ Teknologi

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Responsive design, gradients, animations
- **JavaScript (Vanilla)** - No dependencies required
  - DOM manipulation
  - Local Storage API untuk data persistence
  - Form validation
  - Event handling

### Fitur JavaScript
- **LocalStorage Manager** untuk data member
- **Cart System** untuk kalkulator sampah
- **Modal & Notifications** untuk user feedback
- **Responsive Navigation** dengan hamburger menu
- **Smooth Scrolling** dan transisi
- **Form Validation** dan error handling

## 📁 Struktur File

```
Bank_Sampah/
├── index.html                 # Halaman beranda
├── css/
│   ├── styles.css            # Style utama & responsive
│   ├── auth.css              # Style untuk login/register
│   ├── dashboard.css         # Style dashboard member
│   ├── pages.css             # Style untuk halaman statis
│   └── calculator.css        # Style kalkulator
├── js/
│   ├── script.js             # Script utama & utility
│   ├── auth.js               # Script autentikasi
│   ├── dashboard.js          # Script dashboard
│   └── calculator.js         # Script kalkulator
├── pages/
│   ├── login.html            # Login & Registrasi
│   ├── dashboard.html        # Dashboard member
│   ├── about.html            # Tentang kami
│   ├── services.html         # Layanan detail
│   ├── members.html          # Info member & benefits
│   └── contact.html          # Halaman kontak
└── images/                   # Folder untuk gambar
```

## 🚀 Fitur-Fitur Canggih

### Data Management
- **Local Storage** untuk persistensi data member
  - User profile
  - Waste history
  - Points & rewards
- **Real-time Calculation** untuk sampah

### UI/UX
- **Responsive Design** untuk semua device
- **Mobile-first** approach
- **Smooth Animations** dan transitions
- **Color-coded System** untuk jenis sampah
- **Progress Indicators** dan status badges

### Security
- **Form Validation** client-side
- **Email Format Check**
- **Password Strength Validation** (minimal 8 karakter)
- **Secure Logout** dengan confirmation

### Accessibility
- **Semantic HTML** untuk screen readers
- **ARIA Labels** untuk form fields
- **Keyboard Navigation** support
- **Color Contrast** compliance

## 💾 Data Structure (Local Storage)

### User Data
```javascript
{
  fullName: "Nama Lengkap",
  email: "email@example.com",
  phone: "08123456789",
  address: "Jalan",
  city: "Kota",
  zipCode: "12345",
  registrationDate: "2024-01-01"
}
```

### Waste History
```javascript
{
  id: timestamp,
  date: "1/1/2024",
  items: [
    {
      type: "plastik",
      weight: 2.5,
      price: 8750,
      points: 875
    }
  ],
  totalPrice: 8750,
  totalPoints: 875,
  status: "Selesai"
}
```

### Points Data
```javascript
{
  totalPoints: 2500,
  cashBalance: 250000
}
```

## 📱 Responsive Breakpoints

- **Desktop**: 1200px+
- **Tablet**: 768px - 1199px
- **Mobile**: 0px - 767px

## 🎨 Color Scheme

- **Primary**: #22c55e (Green)
- **Secondary**: #16a34a (Dark Green)
- **Dark**: #1f2937 (Dark Gray)
- **Light**: #f3f4f6 (Light Gray)
- **Success**: #10b981
- **Warning**: #f59e0b
- **Danger**: #ef4444

## 🔧 Cara Menggunakan

### 1. Setup Awal
```bash
# Tidak perlu instalasi dependencies
# Cukup buka index.html di browser
```

### 2. Testing Login
- Email apapun (misal: test@example.com)
- Password minimal 8 karakter

### 3. Navigasi
- Click menu di navbar
- Gunakan hamburger menu di mobile
- Quick links tersedia di footer

### 4. Fitur Kalkulator
1. Pilih jenis sampah
2. Masukkan berat
3. Lihat perhitungan otomatis
4. Tambah ke keranjang
5. Submit untuk menyimpan

## 📊 Features Checklist

- ✅ Responsive Design
- ✅ Authentication System
- ✅ Dashboard dengan Statistik
- ✅ Waste Calculator
- ✅ Shopping Cart
- ✅ Local Storage Persistence
- ✅ Form Validation
- ✅ Modal & Notifications
- ✅ FAQ Section
- ✅ Contact Form
- ✅ Multiple Pages (8+ pages)
- ✅ Smooth Animations
- ✅ Mobile Navigation
- ✅ Social Media Links
- ✅ Maps Integration

## 🎯 Best Practices

- Clean & maintainable code
- Semantic HTML structure
- Mobile-first responsive design
- Progressive enhancement
- Performance optimized
- Accessibility compliant

## 📝 Catatan Penting

1. **Untuk Produksi**: Sambungkan dengan backend API
2. **Database**: Gunakan backend untuk persistent storage
3. **Email**: Integrasikan email service untuk notifikasi
4. **Maps**: Ganti embed maps dengan lokasi sebenarnya
5. **Images**: Tambahkan image assets di folder `/images`

## 👨‍💻 Developer Notes

- Semua script vanilla JavaScript (no frameworks)
- CSS modern dengan Grid & Flexbox
- Browser support: Chrome, Firefox, Safari, Edge (modern versions)
- File size minimal dan fast loading
- No external dependencies required

## 📞 Support & Maintenance

Untuk pertanyaan atau perbaikan, silakan hubungi:
- Email: developer@banksampah.id
- Phone: +62-812-XXXX-XXXX

---

**Created**: January 2024
**Version**: 1.0
**License**: MIT

## 🔐 Backend Setup (Quickstart)

1. Import database schema using the provided `bank_sampah.sql` into your MySQL/MariaDB server.

  Using command line:
  ```bash
  mysql -u root -p bank_sampah < bank_sampah.sql
  ```

2. Edit `inc/config.php` and set your database credentials (`db_host`, `db_name`, `db_user`, `db_pass`).

3. (One-time) create an initial admin account:
  ```bash
  php seed_admin.php
  ```
  Remove or protect `seed_admin.php` after use.

4. For local development you can run PHP built-in server (dev only):
  ```bash
  php -S localhost:8000 -t .
  ```
  Then open https://localhost:8000/pages/login.php (set up TLS or use a reverse proxy for HTTPS).

5. For production, host under Apache/Nginx with TLS (Let's Encrypt) and point document root to the project folder.

Security notes:
- Ensure `inc/config.php` is not exposed publicly and has correct permissions.
- Use HTTPS in production.

