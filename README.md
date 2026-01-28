# Tesaurus Tematis Bahasa Indonesia

Website fullstack dengan admin panel untuk Tesaurus Bahasa Indonesia menggunakan Laravel.

##  Prasyarat

- PHP >= 8.1
- Composer
- SQLite (atau MySQL/PostgreSQL)
- Node.js & NPM (opsional, jika ingin compile assets)

##  Instalasi

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
- Label
- Word Classes 
- Types 
- Categories 
- Beberapa lemma
- User admin 
### 7. Jalankan Development Server

```bash
php artisan serve
```

Website akan berjalan di: `http://localhost:8000`
