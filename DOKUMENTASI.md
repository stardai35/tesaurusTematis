# Dokumentasi Struktur Proyek

## 📂 Struktur Folder

```
tesatema/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   └── AuthenticatedSessionController.php  # Login/Logout
│   │       ├── Admin/
│   │       │   ├── DashboardController.php            # Admin Dashboard
│   │       │   ├── LemmaController.php                # CRUD Lemma
│   │       │   ├── ArticleController.php              # CRUD Artikel
│   │       │   ├── CategoryController.php             # CRUD Kategori
│   │       │   └── WordRelationController.php         # CRUD Relasi Kata
│   │       └── HomeController.php                     # Public Pages
│   └── Models/
│       ├── Article.php           # Model Artikel
│       ├── Category.php          # Model Kategori
│       ├── Label.php             # Model Label (Jenis Kata)
│       ├── Lemma.php             # Model Lemma
│       ├── Subcategory.php       # Model Subkategori
│       ├── Type.php              # Model Type (Relasi)
│       ├── User.php              # Model User
│       ├── WordClass.php         # Model Kelas Kata
│       └── WordRelation.php      # Model Relasi Kata
│
├── database/
│   ├── migrations/               # Database migrations
│   │   ├── 2024_01_01_000001_create_label_table.php
│   │   ├── 2024_01_01_000002_create_word_class_table.php
│   │   ├── 2024_01_01_000003_create_type_table.php
│   │   ├── 2024_01_01_000004_create_category_table.php
│   │   ├── 2024_01_01_000005_create_subcategory_table.php
│   │   ├── 2024_01_01_000006_create_article_table.php
│   │   ├── 2024_01_01_000007_create_lemma_table.php
│   │   └── 2024_01_01_000008_create_word_relation_table.php
│   └── seeders/
│       └── DatabaseSeeder.php    # Data awal/dummy
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                    # Layout utama public
│       ├── admin/
│       │   ├── layouts/
│       │   │   └── app.blade.php                # Layout admin
│       │   ├── dashboard.blade.php              # Dashboard admin
│       │   ├── lemmas/                          # Views CRUD Lemma
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   ├── articles/                        # Views CRUD Artikel
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   ├── categories/                      # Views CRUD Kategori
│       │   │   ├── index.blade.php
│       │   │   ├── create.blade.php
│       │   │   └── edit.blade.php
│       │   └── word-relations/                  # Views CRUD Word Relations
│       │       ├── index.blade.php
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       ├── auth/
│       │   └── login.blade.php                  # Halaman login
│       ├── home.blade.php                       # Halaman beranda
│       ├── search.blade.php                     # Halaman hasil pencarian
│       ├── lemma.blade.php                      # Detail lemma
│       ├── category.blade.php                   # Jelajah kategori
│       ├── about.blade.php                      # Tentang
│       ├── guide.blade.php                      # Petunjuk penggunaan
│       └── team.blade.php                       # Tim redaksi
│
└── routes/
    ├── web.php       # Routes public & admin
    └── auth.php      # Routes authentication
```

## 🗄️ Database Schema

### 1. label (Jenis Kata)
```sql
- id (PK)
- name (varchar)           # nomina, verba, adjektiva, dll
- abbr (varchar, nullable) # n, v, a, dll
```

### 2. word_class (Kelas Kata)
```sql
- id (PK)
- name (varchar)           # Nomina, Verba, Adjektiva, dll
- abbr (varchar, nullable) # n, v, a, dll
```

### 3. type (Tipe Relasi)
```sql
- id (PK)
- name (varchar)           # sinonim, antonim, contoh, kata_terkait
```

### 4. category (Kategori Bidang Ilmu)
```sql
- id (PK)
- num (integer, nullable)  # Nomor urut
- title (varchar)          # Pendidikan, Hukum, Sastra, dll
- slug (varchar, unique)   # pendidikan, hukum, sastra, dll
```

### 5. subcategory (Subkategori)
```sql
- id (PK)
- cat_id (FK -> category)
- num (integer, nullable)
- title (varchar)
- slug (varchar, unique)
```

### 6. article (Artikel/Tema Kata)
```sql
- id (PK)
- cat_id (FK -> category)
- subcat_id (FK -> subcategory, nullable)
- num (integer, nullable)
- title (varchar)
- slug (varchar, unique)
```

### 7. lemma (Kata/Lema)
```sql
- id (PK)
- label_id (FK -> label)
- name (varchar)           # Nama lemma
- name_tagged (varchar, nullable)
- INDEX(name)
```

### 8. word_relation (Relasi Kata)
```sql
- id (PK)
- article_id (FK -> article)
- par_num (integer, nullable)
- wordclass_id (FK -> word_class)
- group_num (integer, nullable)
- type_id (FK -> type)     # sinonim/antonim/contoh/kata_terkait
- word_order (integer, nullable)
- lemma_id (FK -> lemma)
- INDEX(article_id, lemma_id)
```

## 🔄 Flow Data

### Menampilkan Detail Lemma

1. User klik kata "teknologi"
2. Route: `/lema/teknologi`
3. Controller: `HomeController@lemma`
4. Query:
   - Get lemma "teknologi" with relations
   - Get all word_relations by lemma_id
   - Group by type (sinonim, antonim, contoh, kata_terkait)
5. View: `lemma.blade.php` menampilkan data

### Pencarian Kata

1. User input "teknologi" di search box
2. Route: `/cari?q=teknologi&word_class=4`
3. Controller: `HomeController@search`
4. Query:
   - Search lemma WHERE name LIKE '%teknologi%'
   - Filter by word_class if specified
   - Paginate 20 per page
5. View: `search.blade.php` menampilkan hasil

## 🎯 Controller Functions

### HomeController (Public)

| Method | Route | Fungsi |
|--------|-------|--------|
| `index()` | `/` | Halaman beranda dengan stats & navigasi |
| `search()` | `/cari` | Pencarian kata dengan filter |
| `lemma($slug)` | `/lema/{slug}` | Detail lemma dengan relasi |
| `category()` | `/kategori` | Jelajah kata dengan filter kategori |
| `about()` | `/tentang` | Halaman tentang |
| `guide()` | `/petunjuk-penggunaan` | Petunjuk penggunaan |
| `team()` | `/tim-redaksi` | Tim redaksi |

### Admin Controllers

#### LemmaController
- `index()` - List semua lemma dengan search & pagination
- `create()` - Form tambah lemma
- `store()` - Simpan lemma baru
- `edit($lemma)` - Form edit lemma
- `update($lemma)` - Update lemma
- `destroy($lemma)` - Hapus lemma

#### ArticleController
- CRUD untuk artikel/tema kata

#### CategoryController
- CRUD untuk kategori bidang ilmu

#### WordRelationController
- CRUD untuk relasi kata (sinonim, antonim, dll)

## 🎨 UI Components

### Public Website

- **Hero Section**: Gradient background dengan search box
- **Stats Cards**: Menampilkan jumlah kata, entri, sinonim
- **Word Class Cards**: Icon-based navigation untuk kelas kata
- **Category List**: Accordion list untuk bidang ilmu
- **Search Results**: Card-based dengan badge
- **Lemma Detail**: Organized sections untuk sinonim, antonim, contoh
- **Filter Section**: Multi-filter untuk kategori

### Admin Panel

- **Sidebar Navigation**: Sticky sidebar dengan menu icons
- **Topbar**: User info & timestamp
- **Cards**: White cards untuk konten
- **Tables**: Clean table design dengan actions
- **Forms**: Label + input dengan validation
- **Buttons**: Primary, success, danger variants
- **Pagination**: Centered pagination links

## 🔐 Authentication

- Login: `/login`
- Protected routes menggunakan middleware `auth`
- Session-based authentication
- Logout: POST `/logout`

## 💡 Tips Pengembangan

### Menambah Fitur Baru

1. Buat route di `routes/web.php`
2. Buat method di controller yang sesuai
3. Buat view di `resources/views/`
4. Test functionality

### Styling

- CSS ada di dalam `<style>` tag di masing-masing view
- Menggunakan CSS variables untuk consistency
- Responsive design dengan media queries

### Database

- Gunakan migration untuk perubahan schema
- Gunakan seeder untuk data dummy
- Model relationships sudah didefinisikan

---

**Happy Coding!** 🚀
