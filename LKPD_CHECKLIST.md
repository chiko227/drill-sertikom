# Checklist Pengerjaan LKPD

Dokumen ini merangkum implementasi aplikasi terhadap enam tahap pada brief LKPD.

## 01 — Rancang dan bagi tugas
- [x] Struktur data pengguna, workshop, dan pendaftaran.
- [x] Role `peserta` dan `panitia`.
- [x] Relasi: User memiliki banyak Registration; Workshop memiliki banyak Registration; Registration dimiliki User dan Workshop.
- [x] Akun panitia awal dibuat oleh seeder.
- [ ] Kerja tim Git: setiap anggota membuat branch sendiri, push branch, lalu ajukan Pull Request ke branch `main`. Penanggung jawab repository meninjau dan menggabungkan PR.

## 02 — Bangun tampilan
- [x] Daftar workshop dan pencarian.
- [x] Halaman detail workshop.
- [x] Form register dan login.
- [x] Halaman pendaftaran, pembayaran, dan tiket digital.
- [x] Dashboard panitia untuk workshop dan daftar peserta.
- [x] Tampilan responsif berbasis Blade dan CSS.

## 03 — Hidupkan fitur inti
- [x] Register, login, logout.
- [x] Middleware `auth` untuk halaman peserta.
- [x] Middleware `panitia` untuk halaman pengelolaan.
- [x] CRUD workshop.
- [x] Pendaftaran unik per user dan workshop.
- [x] Validasi kuota dan validasi form.

## 04 — Sambungkan pembayaran
- [x] Membuat transaksi Snap melalui Midtrans Sandbox.
- [x] Status awal pendaftaran `pending`.
- [x] Endpoint notifikasi memvalidasi signature Midtrans.
- [x] Status menjadi `paid` setelah notifikasi settlement/capture yang valid.
- [x] Tiket baru dapat dibuka setelah status `paid`.
- [x] Simulasi pembayaran lokal tersedia hanya ketika `APP_ENV=local`.
- [ ] Isi kredensial Sandbox pada `.env` dan atur Notification URL pada dashboard Midtrans sebelum uji transaksi sungguhan.

## 05 — Periksa N+1 dan gabungkan
- [x] Daftar peserta menggunakan eager loading `with(['user','workshop'])`.
- [x] Daftar workshop menghitung jumlah peserta berbayar melalui `withCount`.
- [ ] Bandingkan jumlah query sebelum dan sesudah eager loading menggunakan Laravel Debugbar/Telescope atau query log dengan dataset yang sama.
- [ ] Setiap anggota push branch dan ajukan PR; maintainer review lalu merge ke `main`.

## 06 — Uji dan demokan
- [x] Feature test untuk pendaftaran, larangan tiket belum lunas, tiket lunas, dan pembatasan role panitia.
- [ ] Jalankan `php artisan test` setelah database test tersedia.
- [ ] Demo alur: login → pilih workshop → daftar → bayar Sandbox → cek status → buka tiket.
- [ ] Uji pendaftaran ganda, akses tiket milik akun lain, dan transaksi belum lunas.
- [ ] Setiap anggota menjelaskan bagian kode yang dikerjakan.

## Skenario pengujian manual
1. Peserta membuka daftar workshop dan melihat detail.
2. Peserta mendaftar pada workshop yang kuotanya masih tersedia.
3. Peserta mencoba mendaftar workshop yang sama untuk kedua kalinya; aplikasi menolak pendaftaran ganda.
4. Peserta membuka halaman tiket sebelum membayar; aplikasi menolak akses.
5. Peserta menyelesaikan pembayaran Sandbox; notifikasi valid mengubah status menjadi `paid`.
6. Peserta membuka tiket digital dan melihat kode tiket, nama, workshop, serta jadwal.
7. Peserta mencoba membuka tiket milik akun lain; aplikasi menolak akses.
8. Peserta mencoba membuka halaman panitia; aplikasi menolak akses.
9. Panitia menambah, mengubah, dan menonaktifkan workshop.
10. Panitia mencari dan memfilter data peserta berdasarkan status pembayaran.
