# Implementasi Authentication FloodSense

## Metode yang dipilih

Authentication dibuat secara manual dengan fitur bawaan Laravel (`Auth`, session, middleware `auth`/`guest`, validasi request, dan hashing). Pilihan ini sesuai karena proyek sudah mempunyai `AuthController`, model `User`, rute login/register/logout, dan form awal. Melanjutkan struktur yang tersedia membuat perubahan tetap ringan dan mudah dijelaskan tanpa memasang scaffolding Breeze yang akan menambah struktur UI baru.

## Fitur dan perlindungan halaman

- Register di `/register`: validasi nama, format dan keunikan email, password minimal 8 karakter, serta konfirmasi password.
- Login di `/login`: validasi email/password dan pesan kredensial salah yang tidak membocorkan apakah email terdaftar; sesi diregenerasi setelah berhasil.
- Logout menggunakan POST `/logout`: mengakhiri autentikasi, membatalkan sesi, dan meregenerasi token CSRF.
- Middleware `guest` membatasi halaman/form login dan register bagi pengguna yang belum login.
- Middleware `auth` melindungi `/dashboard`, `/admin/dashboard`, `/admin/statistik`, POST `/laporan`, serta POST `/logout`. Kedua halaman admin juga memakai `RoleMiddleware` untuk role admin.
- Halaman informasi dan daftar laporan (GET `/laporan`) tetap publik; pengunjung harus masuk sebelum dapat mengirim laporan.

## Akun demo dan phpMyAdmin

Jalankan migrasi dan seeder pada database proyek:

```bash
php artisan migrate --seed
```

Seeder membuat satu admin dan lima akun pengguna. Semua dapat login dengan password demo `password`; alamat email pengguna adalah `pengguna1@floodsense.test` sampai `pengguna5@floodsense.test`, dan admin `admin@floodsense.test`. Seeder memakai `updateOrCreate`, sehingga dapat dijalankan ulang tanpa menggandakan akun. Nama pengguna dibuat memakai Faker lokal `id_ID`.

Untuk menunjukkan data di phpMyAdmin, pilih database `tubeswebpro`, buka tabel `users`, lalu tab **Browse/Jelajahi**. Kolom `password` berisi hash bcrypt (`$2y$...`), bukan password asli. Untuk tampilan yang ringkas, jalankan tab SQL:

```sql
SELECT id, name, email, role, password, created_at
FROM users
WHERE email LIKE '%@floodsense.test'
ORDER BY id;
```

Screenshot phpMyAdmin dapat diambil setelah membuka hasil tersebut; password demo tidak ditampilkan sebagai teks karena hanya hash yang disimpan.
