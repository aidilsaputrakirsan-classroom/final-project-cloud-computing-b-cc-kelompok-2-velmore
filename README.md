# VERLY - VELMORE LIBRARY

Website Perpustakaan VERLY (Velmore Library) merupakan sistem berbasis web yang dirancang untuk membantu sekolah dalam mengelola data buku, anggota, serta aktivitas peminjaman dan pengembalian buku.
Sistem ini memudahkan admin dalam pencatatan data perpustakaan serta memberikan kemudahan bagi anggota (siswa/guru) untuk mencari dan meminjam buku secara efisien.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Role & Permissions](#role--permissions)
- [Fitur Berdasarkan Role](#fitur-berdasarkan-role)
- [Generate PDF](#generate-pdf)
- [Import Data](#import-data)
- [Screenshot](#screenshot)
- [Struktur Database](#struktur-database)
- [Penggunaan](#penggunaan)
- [Deployment](#deployment)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## Fitur Utama



## Tech Stack

### Backend
- **Laravel 12.0** - PHP Framework
- **Livewire 3.5** - Full-stack framework untuk Laravel (includes Alpine.js)
- **Spatie Laravel Permission 6.7** - Role dan permission management
- **MySQL** - Database

### Frontend
- **Bootstrap 5** - CSS Framework
- **Sass 1.43.4** - CSS Preprocessor dengan design token system
- **Material Design Icons (MDI)** - Icon library
- **Font Awesome** - Additional icon library
- **jQuery** - For DataTables plugin
- **Alpine.js** - JavaScript framework (included via Livewire)
- **Dark Mode Support** - Dynamic theme switching (light/dark)

### Libraries & Packages
- **Barryvdh DomPDF 3.0** - PDF generation
- **Maatwebsite Excel 3.1** - Excel import/export
- **Laravel Sanctum 4.0** - API authentication
- **League Flysystem AWS S3** - File storage
- **Laravel Mix 6.0** - Asset bundling and compilation
- **Guzzle HTTP 7.8** - HTTP client
- **PHPUnit 11.0** - Testing framework
- **Spatie Ignition** - Enhanced error pages

## Persyaratan Sistem

- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.3
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)
- Extension PHP yang dibutuhkan:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - GD atau Imagick

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/aidilsaputrakirsan/sitasi-itk.git
cd sitasi-itk
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sitasiitk
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Migrasi Database

```bash
# Jalankan migrasi dan seeder
php artisan migrate --seed

# Atau jika ingin fresh install
php artisan migrate:fresh --seed
```

### 6. Setup Storage

```bash
# Create symbolic link untuk storage
php artisan storage:link
```

### 7. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Jalankan Aplikasi

```bash
# Development server
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Konfigurasi

### Email Configuration

Edit konfigurasi email di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sitasi-itk.ac.id
MAIL_FROM_NAME="SITASI ITK"
```

### File Storage

Untuk menggunakan AWS S3 storage, konfigurasi:

```env
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=your-bucket-name
```

## Role & Permissions

Sistem menggunakan 4 role utama dengan permission berbeda:

| Role | Deskripsi |
|------|-----------|
| **Mahasiswa** | Mahasiswa yang mengerjakan tugas akhir |
| **Dosen** | Dosen pembimbing dan penguji |
| **Tendik** | Tenaga Kependidikan (Admin) |
| **Koorpro** | Koordinator Program Studi |

## Fitur Berdasarkan Role

### Mahasiswa
- 📝 Pengajuan judul tugas akhir
- 📚 Pencatatan bimbingan dengan dosen
- 📅 Pendaftaran seminar proposal
- 🎓 Pendaftaran sidang tugas akhir
- 📖 Akses katalog TA
- 📋 Lihat referensi dan prosedur
- 👤 Manajemen profil

### Dosen
- 👥 Lihat daftar mahasiswa bimbingan
- ✅ Validasi dan approve bimbingan
- 📊 Entry penilaian sempro dan sidang
- 📑 Lihat jadwal sempro dan sidang
- 📖 Akses dan kontribusi katalog TA
- 🔍 Monitoring progress mahasiswa

### Tendik (Admin)
- 👨‍🏫 **Data Master**
  - CRUD data dosen
  - CRUD data mahasiswa
  - Import data via Excel
- 📅 **Penjadwalan**
  - Manajemen periode akademik
  - Penjadwalan seminar proposal
  - Penjadwalan sidang tugas akhir
  - Monitoring real-time
- 📚 **Konten**
  - Manajemen katalog TA
  - Manajemen referensi
  - Manajemen prosedur
- 📄 **Dokumentasi**
  - Generate berbagai form dan surat
  - Export data Excel/PDF

### Koorpro (Koordinator Program Studi)
- Semua akses yang dimiliki Tendik
- 📊 Dashboard analytics
- 📈 Laporan dan statistik
- 🎯 Monitoring keseluruhan proses TA

## Generate PDF

Aplikasi dapat generate berbagai dokumen PDF:

### Form Tugas Akhir
- **Form TA-001** - Form Pengajuan Judul TA
- **Form TA-002** - Form Persetujuan Judul TA
- **Form TA-006** - Form Permohonan Seminar Proposal
- **Form TA-007** - Form Permohonan Sidang TA
- **Form TA-008** - Form Lembar Konsultasi

### Dokumen Jadwal
- **Jadwal Seminar Proposal** - Jadwal lengkap sempro per periode
- **Jadwal Sidang TA** - Jadwal lengkap sidang per periode

### Berita Acara
- **Berita Acara Seminar Proposal**
- **Berita Acara Sidang Tugas Akhir**
- **Lembar Persetujuan Revisi**
- **Surat Kesanggupan Revisi**

## Import Data

### Template Excel

Aplikasi menyediakan template Excel untuk import data:

1. **Dosen Template.xlsx** - Template import data dosen
2. **Mahasiswa Template.xlsx** - Template import data mahasiswa
3. **Katalog Template.xlsx** - Template import data katalog TA

Template dapat diunduh dari folder `/public/` atau melalui menu import di aplikasi.

### Cara Import

1. Download template yang sesuai
2. Isi data sesuai format template
3. Upload file Excel melalui halaman import
4. Sistem akan validasi dan import data secara otomatis

## Screenshot

### 1. Halaman Login
![Halaman Login](public/images/screenshots/01-login.png)
*Halaman login dengan form email dan password*

### 2. Dashboard Mahasiswa
![Dashboard Mahasiswa](public/images/screenshots/02-dashboard-mahasiswa.png)
*Dashboard mahasiswa dengan ringkasan status TA*

### 3. Pengajuan Judul TA
![Pengajuan Judul TA](public/images/screenshots/03-pengajuan-judul-ta.png)
*Form pengajuan judul tugas akhir*

### 4. Halaman Bimbingan
![Halaman Bimbingan](public/images/screenshots/04-halaman-bimbingan.png)
*Halaman pencatatan bimbingan dengan dosen*

### 5. Dashboard Dosen
![Dashboard Dosen](public/images/screenshots/05-dashboard-dosen.png)
*Dashboard dosen dengan daftar mahasiswa bimbingan*

### 6. Penjadwalan Sempro
![Penjadwalan Sempro](public/images/screenshots/06-penjadwalan-sempro.png)
*Halaman penjadwalan seminar proposal*

### 7. Data Mahasiswa (Admin)
![Data Mahasiswa Admin](public/images/screenshots/07-data-mahasiswa-admin.png)
*Halaman manajemen data mahasiswa dengan fitur import*

### 8. Generate PDF
![Generate PDF](public/images/screenshots/08-generate-pdf.png)
*Contoh dokumen PDF yang dihasilkan*

### 9. Katalog TA
![Katalog TA](public/images/screenshots/09-katalog-ta.png)
*Halaman katalog tugas akhir*

## Struktur Database

### Tabel Utama

- **users** - Data pengguna sistem (dengan photo dan signature)
- **dosens** - Data dosen (termasuk dosen eksternal)
- **mahasiswas** - Data mahasiswa
- **pengajuan_tas** - Pengajuan tugas akhir
- **bimbingans** - Catatan bimbingan (dengan status approval)
- **sempros** - Data seminar proposal (dengan hasil_sempro)
- **sidang_tas** - Data sidang tugas akhir (dengan tracking revisi)
- **periodes** - Periode akademik (TA dan Sempro)
- **jadwal_sempros** - Jadwal seminar proposal
- **jadwal_tas** - Jadwal sidang TA
- **penilaian_sempros** - Nilai seminar proposal
- **penilaian_sidang_tas** - Nilai sidang TA
- **katalogs** - Katalog tugas akhir (dengan approval system)
- **referensis** - Referensi untuk mahasiswa
- **prosedurs** - Prosedur dan panduan
- **notifikasis** - Notifikasi real-time untuk users
- **riwayat_pengajuans** - Riwayat perubahan pengajuan
- **riwayat_pendaftaran_sempros** - Riwayat pendaftaran sempro
- **riwayat_pendaftaran_sidang_tas** - Riwayat pendaftaran sidang

### Relasi Database

```
users (1) ─── (1) mahasiswas
users (1) ─── (1) dosens

mahasiswas (1) ─── (n) pengajuan_tas
pengajuan_tas (1) ─── (n) bimbingans
pengajuan_tas (1) ─── (1) sempros
pengajuan_tas (1) ─── (1) sidang_tas

periodes (1) ─── (n) jadwal_sempros
periodes (1) ─── (n) jadwal_tas

sempros (1) ─── (n) penilaian_sempros
sidang_tas (1) ─── (n) penilaian_sidang_tas
```

## Arsitektur & Komponen

### Arsitektur Aplikasi

Aplikasi ini menggunakan **Livewire-heavy architecture** dengan 34+ komponen interaktif yang menggantikan kebutuhan AJAX tradisional:

- **Controllers (12)** - Business logic dan routing
- **Livewire Components (34+)** - Full-stack reactive components
- **Models (19)** - Eloquent ORM models dengan relationships
- **Services** - PdfService untuk centralized PDF generation
- **Traits** - Reusable logic (NotifikasiTraits, UpdateDeleteTraits, PeriodeTraits)
- **Imports/Exports** - Excel handling untuk batch operations

### Fitur Teknis Unggulan

- **Real-time Reactivity** - Livewire + Alpine.js untuk interactive UI
- **Role-based Access Control** - Spatie Permission dengan 4 roles
- **Custom Notification System** - Real-time notifications dengan trait
- **PDF Generation** - DomPDF untuk 11+ jenis dokumen
- **Excel Operations** - Import/export dengan validasi
- **Design Token System** - Modern CSS architecture dengan dark mode
- **Responsive Mobile-First** - Optimized untuk semua device

## Testing

### Test Framework

Aplikasi dilengkapi dengan **PHPUnit 11.0** untuk unit dan feature testing:

```bash
# Jalankan semua tests
php artisan test

# Jalankan dengan coverage
php artisan test --coverage

# Jalankan test spesifik
php artisan test --filter=NamaTest
```

### Konfigurasi Test

- **Test Database**: SQLite in-memory untuk isolasi
- **Test Suites**: Unit tests dan Feature tests
- **Mock Services**: Mail, Queue menggunakan array/sync driver
- **Coverage**: Enabled untuk monitoring code quality

## Penggunaan

### Login Pertama Kali

Setelah instalasi dan seeding database, Anda dapat login dengan akun default yang dibuat oleh `UserSeeder`. Periksa file `/database/seeders/UserSeeder.php` untuk kredensial default.

### Workflow Umum

1. **Admin** membuat periode akademik baru
2. **Admin** menginput data mahasiswa dan dosen
3. **Mahasiswa** login dan mengajukan judul TA
4. **Dosen** mereview dan approve pengajuan
5. **Mahasiswa** melakukan bimbingan dan mencatat progress
6. **Mahasiswa** mendaftar sempro setelah syarat terpenuhi
7. **Admin** membuat jadwal sempro
8. **Dosen** memberikan penilaian sempro
9. **Mahasiswa** melanjutkan bimbingan dan mendaftar sidang TA
10. **Admin** membuat jadwal sidang TA
11. **Dosen** memberikan penilaian sidang
12. **Admin** menambahkan ke katalog TA setelah lulus

## Deployment

### Requirements Production

- PHP 8.2 atau lebih tinggi
- MySQL/MariaDB
- Composer
- Node.js & NPM
- Web server dengan SSL certificate

### Production Setup

1. Clone repository ke server
2. Install dependencies
3. Setup environment production
4. Optimize aplikasi:

```bash
# Optimize configuration
php artisan config:cache

# Optimize routes
php artisan route:cache

# Optimize views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

5. Setup cron job untuk scheduled tasks:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

6. Setup queue worker (optional):

```bash
php artisan queue:work --daemon
```

### GitHub Actions

Project ini sudah dilengkapi dengan GitHub Actions untuk auto-deployment. Konfigurasi dapat dilihat di `.github/workflows/deploy.yml`.

## Kontribusi

Kontribusi selalu diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards

- Ikuti PSR-12 coding standard
- Gunakan meaningful variable dan function names
- Tambahkan komentar untuk logika yang kompleks
- Write clean dan maintainable code

## Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

## Credits

- **Laravel Framework** - [https://laravel.com](https://laravel.com)
- **Livewire** - [https://livewire.laravel.com](https://livewire.laravel.com)
- **Soft UI Dashboard** - [https://www.creative-tim.com](https://www.creative-tim.com)
- **Spatie Laravel Permission** - [https://spatie.be](https://spatie.be)

## Support

Jika ada pertanyaan atau issues, silakan:
- Buat issue di GitHub repository
- Hubungi tim development

---

**Developed with ❤️ for Sistem Informasi Institut Teknologi Kalimantan**

*Last updated: November 2025*
