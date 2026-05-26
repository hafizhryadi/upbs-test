# Sistem Informasi Manajemen Benih Padi (UPBS)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

## Deskripsi Proyek
Sistem Informasi Manajemen Benih Padi adalah aplikasi berbasis web yang dibangun menggunakan framework Laravel 12. Sistem ini dirancang untuk memudahkan Unit Pengelola Benih Sumber (UPBS) dalam mengelola persediaan benih padi, melacak pergerakan stok berdasarkan *batch* produksi (lot), serta melayani dan mengelola permintaan benih dari masyarakat umum.

Aplikasi ini dibagi menjadi dua bagian utama:
1. **Halaman Publik (Frontend)**: Antarmuka yang memungkinkan masyarakat umum untuk melihat katalog varietas padi yang tersedia, mengecek ketersediaan stok benih secara *real-time*, dan mengajukan form permintaan benih secara online.
2. **Dashboard Admin (Backend)**: Panel kontrol khusus bagi administrator/pengelola UPBS untuk mengelola data master, mencatat histori transaksi benih masuk dan keluar, menyetujui permintaan benih, dan mengunduh laporan bulanan.

---

## Fitur Utama

### 🌾 Halaman Publik (Masyarakat)
- **Katalog Varietas**: Menampilkan galeri varietas padi beserta deskripsi spesifikasinya.
- **Cek Stok Real-time**: Menampilkan ketersediaan total stok benih berdasarkan akumulasi dari seluruh *batch* panen yang masih tersedia untuk setiap varietas.
- **Pengajuan Permintaan Benih**: Pengunjung dapat mengisi formulir untuk mengajukan permintaan kuota benih kepada UPBS.

### 🔐 Dashboard Admin (Pengelola)
- **Autentikasi Aman**: Sistem login diamankan dengan `laravel/fortify`.
- **Desain Modern & Responsif**: Menggunakan Tailwind CSS v4 dengan dukungan fitur *Dark Mode*.
- **Manajemen Varietas (CRUD)**: Kelola data varietas benih padi (tambah, edit, hapus, detail).
- **Manajemen Lokasi (CRUD)**: Kelola lokasi gudang penyimpanan atau area asal benih.
- **Manajemen Inventori & Batch**: Pantau stok benih secara detail. Sistem mendukung pelacakan berbasis *batch* (lot) sehingga memudahkan proses pengecekan kualitas dan kedaluwarsa benih.
- **Transaksi Inventori**: Pencatatan riwayat transaksi benih **Masuk (In)** dan **Keluar (Out)**. Admin dapat memilih *batch* secara spesifik ketika mengeluarkan benih.
- **Manajemen Permintaan**: Tinjau permintaan benih dari masyarakat. Admin dapat mengubah status permintaan (Disetujui, Ditolak, Menunggu).
- **Laporan Bulanan**: Fitur pembuatan laporan (PDF) rekapitulasi data transaksi dan sisa stok benih dalam periode bulan tertentu (menggunakan `barryvdh/laravel-dompdf`).

---

## Teknologi yang Digunakan
- **Backend Framework**: [Laravel 12.x](https://laravel.com/)
- **Bahasa Pemrograman**: PHP ^8.2
- **Frontend Styling**: [Tailwind CSS v4](https://tailwindcss.com/) & [Vite](https://vitejs.dev/)
- **Database**: MySQL / MariaDB (Dukungan penuh oleh Eloquent ORM Laravel)
- **Autentikasi**: Laravel Fortify
- **PDF Generator**: `barryvdh/laravel-dompdf`

---

## Prasyarat Lingkungan
Sebelum menjalankan proyek ini, pastikan mesin pengembangan Anda telah terinstal:
- **PHP** >= 8.2
- **Composer** (untuk manajemen dependensi PHP)
- **Node.js & NPM** (untuk kompilasi aset frontend)
- **MySQL / MariaDB** (atau database lain yang didukung Laravel)

---

## Panduan Instalasi (Lokal)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di lingkungan *development* (lokal):

**1. Clone Repositori**
```bash
git clone <URL_REPOSITORI_ANDA>
cd crud_test
```

**2. Instal Dependensi PHP**
```bash
composer install
```

**3. Instal Dependensi JavaScript**
```bash
npm install
```

**4. Konfigurasi Environment**
Salin file `.env.example` menjadi `.env`.
```bash
cp .env.example .env
```
Buka file `.env` dan atur konfigurasi database sesuai dengan pengaturan lokal Anda. Contoh:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=password_anda
```

**5. Generate Application Key**
```bash
php artisan key:generate
```

**6. Jalankan Migrasi Database**
Pastikan database sudah dibuat di sistem MySQL Anda sebelum menjalankan perintah ini.
```bash
php artisan migrate
```
*(Opsional: Jika ada seeder, Anda dapat menjalankannya dengan perintah `php artisan migrate --seed`)*

**7. Link Storage**
Untuk memastikan gambar atau file publik dapat diakses:
```bash
php artisan storage:link
```

**8. Jalankan Aplikasi**
Sistem ini menggunakan Vite, sehingga Anda perlu menjalankan server PHP dan server Vite secara bersamaan.
Buka **Terminal 1** untuk Laravel:
```bash
php artisan serve
```
Buka **Terminal 2** untuk kompilasi aset frontend:
```bash
npm run dev
```

Aplikasi kini dapat diakses melalui browser di alamat: `http://localhost:8000`

---

## Struktur Direktori Utama
- `app/Models/`: Berisi struktur model Eloquent ORM (`Inventory`, `Location`, `Request`, `Transaction`, `User`, `Variety`).
- `app/Http/Controllers/`: Logika sistem untuk berbagai fitur seperti `InventoryController`, `ReportController`, `RequestController`, dll.
- `resources/views/`: Berisi file *template* antarmuka menggunakan *Blade*.
- `routes/web.php`: Berisi definisi seluruh *routing* URL sistem.

---

## Lisensi
Proyek ini dikembangkan secara spesifik untuk memenuhi kebutuhan Unit Pengelola Benih Sumber (UPBS).
Segala hak cipta disesuaikan dengan ketentuan instansi terkait.
Framework Laravel sendiri dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
