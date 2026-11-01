# Karhutla Report
S
## 1. Identitas Mahasiswa

| Keterangan | Informasi |
|---|---|
| Nama | Najwan Rachman |
| NIM | 251511024 |
| Program Studi | D3 Teknik Informatika |
| Institusi | Politeknik Negeri Bandung |
| Mata Kuliah | Proyek 3 |
| Nama Proyek | Karhutla Report |

## 2. Kebutuhan Environment

Sebelum menjalankan aplikasi, pastikan perangkat telah memiliki:

- PHP 8.3 atau versi kompatibel dengan Laravel.
- Composer.
- MySQL atau MariaDB.
- Node.js dan npm.
- XAMPP.
- Git.

## 3. Langkah Instalasi

Clone repository GitHub:

```bash
git clone https://github.com/NajwanRachman/ETS-251511024-Karhutla.git
```

Masuk ke direktori proyek Laravel:

```bash
cd ETS-251511024-Karhutla/karhutla
```

Install dependency PHP:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Buat file environment:

```powershell
Copy-Item .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

## 4. Konfigurasi Database

1. Jalankan Apache dan MySQL melalui XAMPP.
2. Buka phpMyAdmin melalui `http://localhost/phpmyadmin`.
3. Buat database baru dengan nama `db_karhutla`.
4. Atur konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_karhutla
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password apabila konfigurasi MySQL berbeda.

## 5. Migration dan Seeding

Jalankan migration untuk membuat tabel database:

```bash
php artisan migrate
```

Jalankan seeder untuk memasukkan data awal dan akun demo:

```bash
php artisan db:seed --class=DemoDataSeeder
```

Buat symbolic link untuk penyimpanan file bukti laporan:

```bash
php artisan storage:link
```

## 6. Akun Demo Setiap Role

Gunakan akun berikut untuk mengakses aplikasi:

| Role | Email | Password |
|---|---|---|
| Reporter | reporter@karhutla.test | password123 |
| Volunteer | volunteer@karhutla.test | password123 |
| Coordinator | coordinator@karhutla.test | password123 |

Akun demo dibuat melalui `DemoDataSeeder`.

## 7. Cara Menjalankan Aplikasi

Pastikan Apache dan MySQL pada XAMPP sudah aktif.

Jalankan server Laravel melalui terminal:

```bash
php artisan serve
```

Jalankan Vite untuk kebutuhan frontend pada terminal lain:

```bash
npm run dev
```

Buka aplikasi melalui browser:

```text
http://127.0.0.1:8000
```

Aplikasi Karhutla Report siap digunakan.