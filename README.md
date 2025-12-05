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
1. **Login Admin & User**  
   Login terpisah agar keamanan data tetap terjaga.  

2. **Dashboard Informasi**  
   Menampilkan ringkasan jumlah total buku, anggota, dan transaksi peminjaman/pengembalian.  

3. **Manajemen Data Buku (CRUD)**  
   Admin dapat menambah, melihat, mengedit, dan menghapus data buku (judul, penulis, tahun terbit, kategori, status).  

4. **Manajemen Data Anggota (CRUD)**  
   Admin dapat mengelola data anggota (nama, kelas/jabatan, kontak, dan status).  

5. **Peminjaman & Pengembalian Buku**  
   Fitur mencatat transaksi peminjaman dan pengembalian buku oleh anggota.  

6. **Riwayat Peminjaman**  
   Menampilkan catatan lengkap transaksi peminjaman dan pengembalian buku.  

7. **Pencarian Buku**  
   Pengguna dapat mencari buku berdasarkan judul, penulis, atau tahun terbit.


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
git clone https://github.com/aidilsaputrakirsan-classroom/final-project-cloud-computing-b-cc-kelompok-2-velmore.git
cd velmore
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

composer require realrashid/sweet-alert

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

# ======================================
# 🗃 KONFIGURASI DATABASE (SUPABASE REST)
# ======================================
SUPABASE_URL=https://seabqhejluhgdzrpmbvh.supabase.co
SUPABASE_KEY=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InNlYWJxaGVqbHVoZ2R6cnBtYnZoIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjE1Mjk5MzksImV4cCI6MjA3NzEwNTkzOX0.gwKXaGURsacidesKniihyxA4SRGGVLH9foOqbfcODig   
SUPABASE_TABLE=buku


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
# ======================================
# MAIL / QUEUE (abaikan untuk sekarang)
# ======================================
MAIL_MAILER=log
QUEUE_CONNECTION=sync

SESSION_DRIVER=file
SESSION_LIFETIME=120

### File Storage

Untuk menggunakan AWS S3 storage, konfigurasi:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:uLZg9WGJqXwnNqVA2Oc6Up+2i7cXNcGU9JALGgTOAuo=
APP_DEBUG=true
APP_URL=APP_URL=https://verly.akhzafachrozy.my.id
```

## Role & Permissions

Sistem menggunakan 4 role utama dengan permission berbeda:

| Role | Deskripsi |
|------|-----------|
| **Penjaga** | Pemberi pinjaman buku (admin) |
| **Siswa** | Peminjam (user) |

# Fitur Berdasarkan Role – VERLY Library System

## 👑 Admin (Penjaga Perpustakaan)

Admin memiliki akses penuh untuk mengelola seluruh aktivitas di sistem.

### Manajemen
- 📊 **Dashboard**  
  Melihat statistik peminjaman, jumlah buku, dan aktivitas terbaru pengguna.

- ➕ **Tambah Pengguna**  
  Membuat akun peminjam atau admin baru.

- 👥 **Data Pengguna**  
  Mengelola detail pengguna seperti nama, email, role.

### Buku & Kategori
- 📚 **Data Buku**  
  Menambah, mengedit, dan menghapus buku serta mengelola stok.

- 🏷️ **Kategori Buku**  
  Mengelompokkan buku berdasarkan kategori tertentu.

### Transaksi
- 🔄 **Transaksi**
  Mengelola seluruh proses peminjaman dan pengembalian.

- 📖 **Peminjaman**  
  Memproses peminjaman buku oleh pengguna.

- 📦 **Pengembalian**  
  Mencatat pengembalian buku dan menghitung denda jika ada keterlambatan.

### Monitoring
- 📅 **Daftar Peminjaman Aktif**  
  Memantau seluruh buku yang masih dipinjam:  
  - Judul buku  
  - Nama peminjam  
  - Kontak  
  - Tanggal pinjam  
  - Tanggal kembali  
  - Status waktu (on time / terlambat)

### Sistem
- 🚪 **Logout**

---

## 👤 User (Peminjam/Siswa)

User hanya dapat melakukan aktivitas yang berkaitan langsung dengan peminjaman buku.

- 📚 **Lihat Katalog Buku**  
  Menjelajahi daftar buku yang tersedia.

- 📖 **Meminjam Buku**  
  Mengajukan peminjaman sesuai ketersediaan.

- 📦 **Mengembalikan Buku**  
  Mengembalikan buku yang dipinjam melalui sistem.

- 🔍 **Riwayat & Status Peminjaman**  
  Melihat:
  - Buku yang sedang dipinjam  
  - Riwayat peminjaman  
  - Status waktu (berapa hari tersisa atau terlambat)

---

## Screenshot

### 1. Halaman Login 
![Halaman Login](public/img/final/login.png)
*Halaman login dengan form email dan password*

### 2. Dashboard Admin
![Dashboard Admin](public/img/final/dashboard-admin.png)
*Dashboard Admin untuk melihat statistik peminjaman, jumlah buku, dan aktivitas terbaru pengguna*

### 3. Halaman Tambah Pengguna (Admin)
![Halaman Tambah Pengguna](public/img/final/tambah-user.png)
*Halaman untuk membuat akun peminjam atau admin baru*

### 4. Halaman Data Pengguna (Admin)
![Halaman Data Pengguna Pengguna](public/img/final/data-user.png)
*Halaman untuk mengelola detail pengguna seperti nama, email, role*

### 5. Halaman Data Buku (Admin)
![Halaman Data Buku](public/img/final/data-buku.png)
*Halaman untuk menambah, mengedit, dan menghapus buku serta mengelola stok*

### 6. Halaman Kategori (Admin)
![Halaman Kategori](public/img/final/data-buku.png)
*Halaman untuk mengelompokkan buku berdasarkan kategori tertentu*

### 7. Halaman Peminjaman (Admin)
![Halaman Peminjaman](public/img/final/peminjaman.png)
*Halaman untuk melihat pengajuan peminjaman sesuai ketersediaan*

### 8. Halaman Pengembalian (Admin)
![Halaman Pengembalian](public/img/final/pengembalian.png)
*Halaman untuk pengembalian buku yang dipinjam melalui sistem*

### 10. Dashboard User
![Dashboard User](public/img/final/dashboard-user.png)
*Halaman untuk menjelajahi daftar buku yang tersedia*

### 11. Halaman Pengembalian (User)
![Halaman Pengembalian](public/img/final/pengembalian-user.png)
*Halaman untuk mengembalikan buku yang dipinjam melalui sistem*

### 12. Halaman Riwayat (User)
![Halaman Riwayat](public/img/final/riwayat.png)
*Halaman untuk melihat buku yang sedang dipinjam, riwayat peminjaman, status waktu (berapa hari tersisa atau terlambat)*

## Struktur Database

### Tabel Utama

- **activity_logs** – Catatan aktivitas pengguna sistem, meliputi aksi yang dilakukan, alamat IP, user agent, serta waktu pencatatan.

- **kategori_buku** – Data kategori buku yang digunakan untuk mengelompokkan koleksi perpustakaan.

- **buku** – Data lengkap buku, mencakup judul, pengarang, penerbit, deskripsi, tahun terbit, kode buku, status ketersediaan, dan keterhubungan dengan kategori buku.
- **Peminjaman** – Judul Buku	,Peminjam	Kontak,	Tanggal Pinjam,	Tanggal Kembali,	Sisa Waktu.


## Relasi Database

### Hubungan Antar Tabel

- **kategori_buku (1) → (n) buku**  
  Satu kategori dapat memiliki banyak buku.

- **buku (1) → (n) activity_logs**  
  Setiap aksi pada buku (melihat detail, meminjam, mengembalikan) tercatat dalam activity_logs.

### Alur Relasi (Dari Peminjaman Sampai Pengembalian)

1. **User melakukan aksi**  
   → dicatat dalam **activity_logs.action**

2. **User memilih buku**  
   → data diambil dari tabel **buku**

3. **Status buku berubah**  
   - dari **Tersedia → Dipinjam**
   - dari **Dipinjam → Tersedia**

4. **Perubahan status tercatat di activity_logs**  
   → log berisi user_id, action, ip_address, user_agent, dan timestamp

5. **Buku selalu terhubung ke kategori**  
   → lewat **buku.id_kategori → kategori_buku.id**


## Arsitektur & Komponen

### Arsitektur Aplikasi

Aplikasi ini dibangun dengan arsitektur yang sederhana namun modular, memanfaatkan Supabase sebagai fondasi utama untuk **database PostgreSQL**, **autentikasi**, dan **storage**. Setiap modul dipisahkan berdasarkan fungsi agar mudah dikembangkan dan dipelihara.

- **Controllers** – Mengelola routing serta memproses permintaan dari pengguna.
- **Models** – Representasi data yang terhubung langsung dengan database PostgreSQL Supabase.
- **Services** – Tempat logika aplikasi seperti pengelolaan user, manajemen buku, atau integrasi ke Supabase.
- **Traits** – Bagian logika yang digunakan ulang, seperti `ActivityLogger`, `CRUDTraits`, dan `KategoriTraits`.
- **Imports/Exports** – Penanganan file Excel untuk kebutuhan input data massal.
- **Middleware** – Pembatasan akses berdasarkan role dan status login.

Aplikasi dapat berjalan secara hybrid, mendukung SSR (server-side rendering) sekaligus API endpoint untuk interaksi frontend modern bila dibutuhkan.

### Fitur Teknis Utama

- **Supabase Auth** – Sistem autentikasi modern dengan token-based security.
- **Role-based Access Control** – Pengaturan hak akses berdasarkan peran (admin, petugas, user).
- **Activity Logging** – Penyimpanan aktivitas pengguna otomatis ke tabel `activity_logs`.
- **Kategori & Manajemen Buku** – CRUD buku, kategori, status ketersediaan, dan metadata buku.
- **Excel Import/Export** – Mendukung unggah dan unduh data buku/kategori melalui Excel.
- **Storage Management** – Penyimpanan gambar buku melalui Supabase Storage.
- **Runtime Notification System** – Notifikasi sistem yang direkam ke database dan ditampilkan ke user.
- **Responsive UI** – Tampilan dibuat fleksibel dan mobile-friendly.


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

- **Test Database**: PostgreSQL (Supabase) khusus untuk testing, dipisahkan dari database development dan production.  
  Gunakan URL Supabase testing atau jalankan instance PostgreSQL lokal untuk menghindari modifikasi data di Supabase utama.

- **Test Suites**: Unit tests dan Feature tests dijalankan menggunakan koneksi database testing yang sudah dipre-seed dengan schema terbaru.

- **Mock Services**:  
  - Auth Supabase dimock menggunakan token/JWT palsu.  
  - Storage dimock menggunakan filesystem lokal.  
  - Email & Queue tetap menggunakan driver `array` atau `sync` untuk menghindari pengiriman ke layanan Supabase asli.

- **Coverage**: Coverage tetap diaktifkan untuk memantau kualitas kode, terutama integrasi yang menyentuh Supabase SDK.



## Penggunaan

### Login Pertama Kali

Setelah instalasi dan seeding database, Anda dapat login dengan akun default yang dibuat oleh `UserSeeder`. Periksa file `/database/seeders/UserSeeder.php` untuk kredensial default.

### Workflow Umum

1. **Admin** melengkapi katalog buku yang tersedia
2. **Peminjam** mendaftarkan diri sebagai anggota perpustakaan 
3. **Admin** menambahkan data anggota baru 
4. **Peminjam** melakukan peminjaman buku 
5. **Admin** memonitoring peminjaman buku yang dilakukan anggota 
6. **Peminjam** mengembalikan buku 
7. **Anggota** melihat riwayat peminjaman buku 
8. **Admin** memonitoring pengembalian buku yang dilakukan anggota 
9. **Admin** menambahkan koleksi buku baru ke katalog perpustakaan

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

*Last updated: Desember 2025*
