# Tesaurus Tematis Bahasa Indonesia

<<<<<<< HEAD
## 📋 Prasyarat
=======
Website fullstack dengan admin panel untuk Tesaurus Bahasa Indonesia menggunakan Laravel.

##  Prasyarat
>>>>>>> 2ccbe130ad8317c146b8e51a49a0462fd75a888b

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

<<<<<<< HEAD
=======
Data awal yang akan dibuat:
- Label
- Word Classes 
- Types 
- Categories 
- Beberapa lemma
- User admin 
>>>>>>> 2ccbe130ad8317c146b8e51a49a0462fd75a888b
### 7. Jalankan Development Server

```bash
php artisan serve
```

Website akan berjalan di: `http://localhost:8000`
<<<<<<< HEAD


## 🛠 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Vanilla CSS
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel Auth (Custom)
=======
>>>>>>> 2ccbe130ad8317c146b8e51a49a0462fd75a888b
