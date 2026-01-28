# Tesaurus Tematis Bahasa Indonesia

Website fullstack dengan admin panel untuk Tesaurus Bahasa Indonesia menggunakan Laravel.

## 🚀 Fitur

### Public Website
- ✅ Halaman beranda dengan hero gradient dan search
- ✅ Pencarian kata dengan filter kelas kata
- ✅ Detail lemma dengan sinonim, antonim, contoh, dan kata terkait
- ✅ Jelajah kategori dengan filter (kelas kata, bidang, abjad)
- ✅ Halaman statis (Tentang, Petunjuk Penggunaan, Tim Redaksi)
- ✅ Design modern sesuai UI/UX yang diberikan

### Admin Panel
- ✅ Dashboard dengan statistik
- ✅ CRUD Lemma (kata/lema)
- ✅ CRUD Artikel (tema kata)
- ✅ CRUD Kategori (bidang ilmu)
- ✅ CRUD Word Relations (sinonim, antonim, contoh, kata terkait)
- ✅ Autentikasi (Login/Logout)
- ✅ Modern admin UI dengan sidebar navigation

## 📋 Prasyarat

- PHP >= 8.1
- Composer
- SQLite (atau MySQL/PostgreSQL)
- Node.js & NPM (opsional, jika ingin compile assets)

## 🔧 Instalasi

### 1. Install Dependencies

```bash
composer install
```

### 2. Setup Environment

Copy file `.env.example` dan rename menjadi `.env`:

```bash
copy .env.example .env
```

File `.env` sudah dikonfigurasi untuk menggunakan SQLite.

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Buat Database SQLite

```bash
type nul > database\database.sqlite
```

Atau buat file kosong bernama `database.sqlite` di folder `database/`.

### 5. Jalankan Migrasi

```bash
php artisan migrate
```

### 6. Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

Data awal yang akan dibuat:
- Label (nomina, verba, adjektiva, dll)
- Word Classes (Adjektiva, Adverbia, Konjungsi, dll)
- Types (sinonim, antonim, contoh, kata_terkait)
- Categories (Pendidikan, Hukum, Sastra, Teknologi)
- Beberapa contoh lemma
- User admin (email: `admin@tesaurus.com`, password: `password`)

### 7. Jalankan Development Server

```bash
php artisan serve
```

Website akan berjalan di: `http://localhost:8000`

## 🔐 Login Admin

Akses admin panel di: `http://localhost:8000/admin`

**Kredensial default:**
- Email: `admin@tesaurus.com`
- Password: `password`

## 📁 Struktur Database

### Tables

1. **label** - Jenis kata (nomina, verba, dll)
2. **word_class** - Kelas kata (Adjektiva, Adverbia, dll)
3. **type** - Tipe relasi (sinonim, antonim, contoh, kata_terkait)
4. **category** - Kategori bidang ilmu
5. **subcategory** - Subkategori
6. **article** - Artikel/tema kata
7. **lemma** - Lemma/kata dasar
8. **word_relation** - Relasi antar kata
9. **users** - User admin

### Relationships

- `Lemma` belongsTo `Label`
- `Lemma` hasMany `WordRelation`
- `Article` belongsTo `Category` dan `Subcategory`
- `Article` hasMany `WordRelation`
- `WordRelation` belongsTo `Article`, `Lemma`, `WordClass`, `Type`

## 🎨 Routes

### Public Routes
- `/` - Halaman beranda
- `/cari` - Halaman pencarian
- `/kategori` - Jelajah kategori dengan filter
- `/lema/{slug}` - Detail lemma
- `/tentang` - Tentang
- `/petunjuk-penggunaan` - Petunjuk penggunaan
- `/tim-redaksi` - Tim redaksi

### Admin Routes (Protected)
- `/admin` - Dashboard
- `/admin/lemmas` - CRUD Lemma
- `/admin/articles` - CRUD Artikel
- `/admin/categories` - CRUD Kategori
- `/admin/word-relations` - CRUD Relasi Kata

## 📝 Cara Penggunaan

### Menambah Lemma Baru

1. Login ke admin panel
2. Klik menu "Lemma" di sidebar
3. Klik tombol "+ Tambah Lemma"
4. Isi form:
   - Label: Pilih jenis kata (nomina, verba, dll)
   - Nama Lemma: Kata yang ingin ditambahkan
   - Nama Tagged: Opsional, untuk tagged version
5. Klik "Simpan"

### Menambah Relasi Kata (Sinonim, Antonim, dll)

1. Pastikan sudah ada Article dan Lemma
2. Klik menu "Relasi Kata"
3. Klik "+ Tambah Relasi"
4. Isi form:
   - Artikel: Pilih artikel terkait
   - Lemma: Pilih lemma
   - Kelas Kata: Pilih kelas kata
   - Tipe Relasi: Pilih sinonim/antonim/contoh/kata_terkait
5. Klik "Simpan"

### Menambah Kategori

1. Klik menu "Kategori"
2. Klik "+ Tambah Kategori"
3. Isi nomor urut dan judul kategori
4. Slug akan dibuat otomatis
5. Klik "Simpan"

## 🛠 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Vanilla CSS
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel Auth (Custom)

## 🎯 Design Philosophy

Website ini didesain dengan prinsip:
- **Modern & Clean UI** - Menggunakan gradient, card, dan micro-animations
- **User-Friendly** - Navigasi intuitif dan search yang mudah
- **Responsive** - Mobile-friendly design
- **SEO Optimized** - Proper meta tags dan semantic HTML

## 📚 Referensi

Desain dan fungsionalitas terinspirasi dari:
- https://tesaurus.kemendikdasmen.go.id/tematis/

## 🤝 Contribution

Untuk menambahkan fitur baru atau memperbaiki bug:

1. Buat perubahan di controller/view yang sesuai
2. Test di local development
3. Commit dengan pesan yang jelas

## 📄 License

Developed for educational purposes.

---

**Dibuat dengan ❤️ menggunakan Laravel**
