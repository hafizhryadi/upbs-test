# Kamus Data (Data Dictionary)

Berikut adalah kamus data untuk proyek ini, disesuaikan dengan format tabel yang diminta.

### Tabel: `users`
Menyimpan data pengguna atau administrator sistem.

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | name | varchar | 50 | Nama lengkap pengguna |
| 3 | email | varchar | 50 | Alamat email pengguna (Unique) |
| 4 | email_verified_at | timestamp | - | Waktu verifikasi email (Nullable) |
| 5 | password | varchar | 50 | Password (Hashed) |
| 6 | remember_token | varchar | 100 | Token untuk fitur *remember me* (Nullable) |
| 7 | created_at | timestamp | - | Waktu data dibuat |
| 8 | updated_at | timestamp | - | Waktu data terakhir diubah |

### Tabel: `varieties`
Menyimpan data varietas/jenis benih yang tersedia.

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | name | varchar | 70 | Nama varietas (Unique) |
| 3 | description | text | - | Deskripsi atau informasi tambahan varietas (Nullable) |
| 4 | created_at | timestamp | - | Waktu data dibuat |
| 5 | updated_at | timestamp | - | Waktu data terakhir diubah |

### Tabel: `locations`
Menyimpan data lokasi atau gudang penyimpanan.

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | name | varchar | 70 | Nama lokasi/gudang |
| 3 | address | varchar | 255 | Alamat lengkap lokasi |
| 4 | created_at | timestamp | - | Waktu data dibuat |
| 5 | updated_at | timestamp | - | Waktu data terakhir diubah |

### Tabel: `inventories`
Menyimpan data stok barang/benih di setiap lokasi beserta detail *batch*-nya.

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | variety_id | bigint | 20 | Foreign Key ke tabel `varieties` |
| 3 | location_id | bigint | 20 | Foreign Key ke tabel `locations` |
| 4 | batch_code | varchar | 50 | Kode produksi / batch |
| 5 | expiry_date | date | - | Tanggal kedaluwarsa |
| 6 | quantity | int | 11 | Jumlah stok tersedia |
| 7 | created_at | timestamp | - | Waktu data dibuat |
| 8 | updated_at | timestamp | - | Waktu data terakhir diubah |

### Tabel: `transactions`
Menyimpan log riwayat pergerakan barang (masuk/keluar).

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | variety_id | bigint | 20 | Foreign Key ke tabel `varieties` |
| 3 | inventory_id | bigint | 20 | Foreign Key ke tabel `inventories` (Nullable) |
| 4 | trx_date | date | - | Tanggal transaksi dilakukan |
| 5 | trx_type | enum | - | Jenis transaksi: `'masuk'`, `'keluar'` (Default: `'keluar'`) |
| 6 | category | enum | - | Kategori: `'penjualan'`, `'diseminasi'`, `'penyesuaian'` (Nullable) |
| 7 | quantity | int | 11 | Jumlah kuantitas yang ditransaksikan |
| 8 | note | text | - | Catatan tambahan transaksi (Nullable) |
| 9 | created_at | timestamp | - | Waktu data dibuat |
| 10 | updated_at | timestamp | - | Waktu data terakhir diubah |

### Tabel: `requests`
Menyimpan data permohonan atau pemesanan benih dari pihak luar/klien.

| No | Nama Field | Tipe Data | Size | Keterangan |
| :---: | :--- | :--- | :---: | :--- |
| 1 | id | bigint | 20 | Primary Key, Auto Increment |
| 2 | nama | varchar | 50 | Nama pemohon |
| 3 | phone | varchar | 15 | Nomor telepon pemohon |
| 4 | email | varchar | 50 | Alamat email pemohon (Nullable) |
| 5 | alamat | text | - | Alamat lengkap pemohon |
| 6 | variety_id | bigint | 20 | Foreign Key ke tabel `varieties` (Nullable) |
| 7 | jumlah | int | 11 | Jumlah kuantitas yang diminta |
| 8 | jenis | enum | - | Jenis permintaan: `'pembelian'`, `'diseminasi'` (Default: `'pembelian'`) |
| 9 | surat_permohonan | varchar | 255 | Path / link dokumen surat permohonan (Nullable) |
| 10 | status | enum | - | Status permohonan: `'pending'`, `'disetujui'`, `'ditolak'` (Default: `'pending'`) |
| 11 | created_at | timestamp | - | Waktu data dibuat |
| 12 | updated_at | timestamp | - | Waktu data terakhir diubah |
