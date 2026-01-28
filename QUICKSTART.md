# 🚀 Quick Start Guide

Panduan cepat untuk menjalankan aplikasi Tesaurus Tematis.

## Prerequisites

Pastikan PHP dan Composer sudah terinstall di sistem Anda.

## Langkah-langkah (5 Menit)

### 1. Install Dependencies (1 menit)

Buka terminal di folder proyek, jalankan:

```bash
composer install
```

### 2. Setup Database (1 menit)

Buat file database SQLite:

**Windows:**
```bash
type nul > database\database.sqlite
```

**Mac/Linux:**
```bash
touch database/database.sqlite
```

### 3. Migrate & Seed (2 menit)

Jalankan migrations dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

Data awal yang akan dibuat:
- ✅ Label kata (nomina, verba, adjektiva, dll) - 6 entries
- ✅ Word Classes (Adjektiva, Adverbia, Konjungsi, Nomina, dll) - 7 entries
- ✅ Types (sinonim, antonim, contoh, kata_terkait) - 4 entries
- ✅ Categories (Pendidikan, Hukum, Sastra, Teknologi) - 4 entries
- ✅ Contoh Lemma (teknologi, ilmu terapan, sistem, dll) - 6 entries
- ✅ Admin User (admin@tesaurus.com / password)

### 4. Jalankan Server (1 menit)

```bash
php artisan serve
```

Website akan berjalan di: **http://localhost:8000**

## ✅ Verifikasi

### Public Website

1. Buka http://localhost:8000
2. Anda akan melihat:
   - Hero section dengan search box
   - Statistik (Jumlah Kata, Jumlah Entri, Relasi Sinonim)
   - Navigasi kelas kata (Adjektiva, Adverbia, dll)
   - Daftar bidang ilmu

### Admin Panel

1. Buka http://localhost:8000/admin
2. Login dengan:
   - **Email**: `admin@tesaurus.com`
   - **Password**: `password`
3. Anda akan masuk ke dashboard admin

## 📝 Langkah Selanjutnya

### A. Tambah Data Melalui Admin Panel

1. **Tambah Lemma Baru**
   - Klik "Lemma" di sidebar
   - Klik "+ Tambah Lemma"
   - Isi form dan simpan

2. **Tambah Artikel**
   - Klik "Artikel" di sidebar
   - Klik "+ Tambah Artikel"
   - Pilih kategori dan isi judul

3. **Tambah Relasi Kata**
   - Klik "Relasi Kata" di sidebar
   - Klik "+ Tambah Relasi"
   - Hubungkan lemma dengan artikel, tentukan tipe (sinonim/antonim/dll)

### B. Import Data dari Database Lama (Jika Ada)

Jika Anda memiliki database existing:

1. Export data dari database lama
2. Format sesuai struktur tabel (lihat DOKUMENTASI.md)
3. Import menggunakan:
   ```bash
   php artisan db:seed --class=YourCustomSeeder
   ```

### C. Kustomisasi Tampilan

1. Edit file di `resources/views/` untuk mengubah tampilan
2. CSS ada di dalam `<style>` tag di masing-masing view
3. Reload halaman untuk melihat perubahan

## 🐛 Troubleshooting

### Error: "PHP not recognized"

**Windows (Laragon):**
```bash
C:\laragon\bin\php\php-8.x.x\php artisan serve
```

Atau tambahkan PHP ke PATH.

### Error: "Database not found"

Pastikan file `database/database.sqlite` sudah dibuat.

### Error: "Class not found"

Jalankan:
```bash
composer dump-autoload
php artisan optimize:clear
```

### Error saat migrate

Hapus database dan buat ulang:
```bash
del database\database.sqlite              # Windows
rm database/database.sqlite               # Mac/Linux

type nul > database\database.sqlite       # Windows
touch database/database.sqlite            # Mac/Linux

php artisan migrate:fresh --seed
```

## 📚 Resources

- **README.md** - Dokumentasi lengkap instalasi
- **DOKUMENTASI.md** - Struktur proyek dan database schema
- **routes/web.php** - Daftar semua routes
- **app/Http/Controllers/** - Logika controller

## 🎯 Fitur yang Tersedia

### Public
- ✅ Homepage dengan search
- ✅ Search dengan filter kelas kata
- ✅ Detail lemma dengan sinonim/antonim/contoh
- ✅ Browse kategori dengan filter
- ✅ Halaman statis (Tentang, Petunjuk, Tim)

### Admin
- ✅ Dashboard dengan statistik
- ✅ CRUD Lemma
- ✅ CRUD Artikel
- ✅ CRUD Kategori
- ✅ CRUD Relasi Kata
- ✅ Authentication (Login/Logout)

## 🎨 Design

Website menggunakan design modern dengan:
- Gradient hero section
- Card-based layout
- Clean typography (Inter font)
- Responsive design
- Smooth animations

Sesuai dengan desain UI/UX yang diberikan.

---

**Selamat menggunakan Tesaurus Tematis!** 🎉

Jika ada pertanyaan, lihat dokumentasi lengkap di README.md atau DOKUMENTASI.md.
