# WorkshopIT — Sistem Pendaftaran Workshop Sekolah

Aplikasi Laravel untuk melihat workshop IT, membuat akun peserta, mendaftar, melakukan pembayaran Midtrans Sandbox, dan memperoleh tiket digital setelah pembayaran terverifikasi.

## Fitur
- Register, login, logout, dan pembagian role `peserta` / `panitia`.
- Daftar dan detail workshop dengan pencarian.
- Pendaftaran unik per peserta dan workshop serta pengecekan kuota.
- Halaman pembayaran dan integrasi Midtrans Snap Sandbox.
- Endpoint notifikasi Midtrans dengan validasi signature.
- Tiket digital hanya dapat dibuka setelah status pembayaran `paid`.
- Panel panitia untuk CRUD workshop dan melihat daftar peserta.
- Optimasi daftar peserta menggunakan eager loading `with(['user','workshop'])`.
- Data awal workshop dan akun panitia melalui seeder.

## Persyaratan
- PHP 8.3 atau lebih baru beserta ekstensi database yang sesuai.
- Composer.
- MySQL 8+ (atau SQLite jika ekstensi PDO SQLite tersedia).
- Node.js dan npm jika ingin membangun asset Vite.

## Menjalankan di Laragon (Windows)
1. Ekstrak folder `drill-sertikom` ke `C:\laragon\www\drill-sertikom`.
2. Buka terminal pada folder project.
3. Install dependency jika folder `vendor` belum tersedia:
   ```bash
   composer install
   npm install
   ```
4. Salin `.env.example` menjadi `.env`, lalu atur koneksi database MySQL:
   ```env
   APP_NAME=WorkshopIT
   APP_URL=http://127.0.0.1:8000
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=workshop_it
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Buat database `workshop_it` di phpMyAdmin / HeidiSQL.
6. Jalankan:
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
   ```
7. Buka `http://127.0.0.1:8000`.

Jika memakai Vite:
```bash
npm run build
```

## Akun awal
Seeder membuat akun panitia berikut:
- Email: `panitia@workshop.test`
- Password: `password`

Ganti password akun panitia sebelum aplikasi dipakai di luar lingkungan latihan. Peserta dapat membuat akun melalui halaman Daftar.

## Konfigurasi Midtrans Sandbox
Isi key dari dashboard Sandbox Midtrans pada `.env`:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-...
MIDTRANS_CLIENT_KEY=SB-Mid-client-...
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/v1/transactions
MIDTRANS_SNAP_JS_URL=https://app.sandbox.midtrans.com/snap/snap.js
```
Atur Payment Notification URL di dashboard Midtrans ke:
`https://alamat-publik-kamu/payments/midtrans/notification`

Untuk pengujian lokal tanpa key Midtrans, halaman pembayaran menyediakan tombol simulasi yang hanya aktif ketika `APP_ENV=local`. Tombol ini bukan alur pembayaran produksi.

## Alur demo
1. Masuk sebagai peserta atau buat akun baru.
2. Pilih workshop lalu tekan Daftar workshop.
3. Buka halaman pembayaran. Dengan kredensial Sandbox, lanjutkan pembayaran melalui Midtrans; untuk uji lokal dapat memakai simulasi.
4. Setelah status berubah menjadi `paid`, buka Tiket Saya untuk menampilkan tiket digital.
5. Masuk sebagai panitia untuk menambah/mengubah workshop dan memeriksa pendaftar.

## Catatan implementasi
- Status awal pendaftaran adalah `pending`.
- Tiket hanya dapat diakses oleh pemilik pendaftaran dan hanya jika pembayaran `paid`.
- Callback Midtrans memeriksa `signature_key` sebelum memperbarui status.
- Jangan pernah menaruh Server Key Midtrans di kode frontend atau repository publik.
