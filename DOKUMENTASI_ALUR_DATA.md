# Dokumentasi Lengkap Alur Data Tesaurus Tematis

## 📋 Overview

Sistem Tesaurus Tematis Bahasa Indonesia telah diimplementasikan dengan struktur data yang sesuai dengan petunjuk penggunaan resmi dari Badan Pengembangan dan Pembinaan Bahasa, Kementerian Pendidikan dan Kebudayaan Republik Indonesia.

**Sumber Referensi**: https://tesaurus.kemendikdasmen.go.id/tematis/petunjuk_penggunaan

---

## 🗂️ Struktur Data

### Entitas Utama

```
┌─────────────┐
│  Category   │──────┐
└─────────────┘      │
                     ▼
            ┌────────────────┐
            │ Subcategory    │
            └────────────────┘
                     │
                     ▼
            ┌────────────────┐
            │   Article      │────────────┐
            └────────────────┘            │
                                          ▼
                            ┌──────────────────────┐
                            │  WordRelation        │
                            │  (Paragraph Data)    │
                            └──────────────────────┘
                             │                    │
                             ▼                    ▼
                          ┌────────┐       ┌──────────────┐
                          │ Lemma  │       │ LabelType    │
                          │        │       │ (Sinonimi,   │
                          │        │       │  Hiponimi,   │
                          │        │       │  Meronimi)   │
                          └────────┘       └──────────────┘
```

### Tabel Database

#### 1. **article**
Menyimpan judul artikel (rencana 522 artikel)
- `id`: Primary key
- `cat_id`: Foreign key ke category
- `subcat_id`: Foreign key ke subcategory
- `num`: Nomor urut artikel
- `title`: Judul artikel (HURUF KAPITAL)
- `slug`: Slug untuk URL

#### 2. **word_relation** (TABEL UTAMA)
Menyimpan struktur paragraf dan relasi kata
- `id`: Primary key
- `article_id`: Artikel yang memuat kata
- `lemma_id`: Kata dasar (NULLABLE untuk superordinat)
- `par_num`: Nomor paragraf (1, 2, 3, ...)
- `meaning_group`: Kelompok makna dalam paragraf (untuk pemisah titik koma)
- `wordclass_id`: Kelas kata (Nomina, Verba, dll)
- `type_id`: Tipe hubungan
- `word_order`: Urutan kata dalam paragraf
- **`is_superordinate`**: Flag untuk superordinat (GERAK CEPAT, WARNA, dll)
- **`is_bold`**: Flag untuk acuan ke artikel lain (akan menjadi link)
- **`description`**: Penjelasan atau deskripsi kata
- **`foreign_language`**: Penjelasan bahasa asing (cetak miring)
- **`language_variant`**: Ragam bahasa (cak=cakapan, kas=kasar, hor=hormat)
- **`relationship_type`**: Jenis relasi makna

#### 3. **label_type**
Jenis relasi makna sesuai Tesaurus
- `id`: Primary key
- `name`: sinonimi, hiponimi, meronimi, antonimi
- `description`: Penjelasan

---

## 🔤 Sistem Ortografi dan Tanda Baca

### 1. Cetak Tebal & Huruf Kapital
**Untuk**: Judul artikel
```
GERAK CEPAT
WARNA BIRU
```

**Dalam database**:
```php
// Superordinat
is_superordinate = true
description = 'GERAK CEPAT'
lemma_id = NULL
```

### 2. Cetak Miring
**Untuk**: Penjelasan kata asing
```
quick (English)
```

**Dalam database**:
```php
// Kata dengan penjelasan asing
foreign_language = 'English: quick'
```

### 3. Koma (,)
**Untuk**: Hubungan makna SAMA
```
cepat, kilat, gesit, segera
```

**Dalam database**: Kata-kata dengan `meaning_group` yang SAMA
```php
meaning_group = 1  // Semua dalam grup 1
relationship_type = 1  // sinonimi
```

### 4. Titik Koma (;)
**Untuk**: Hubungan makna BERBEDA tapi DEKAT
```
cepat, kilat, gesit, segera; lekas, deras
                           ↑
                     Titik koma
```

**Dalam database**: Kata-kata dengan `meaning_group` BERBEDA
```php
// Grup 1
meaning_group = 1
word_order = 1, 2, 3, 4

// Grup 2 (nuansa berbeda)
meaning_group = 2
word_order = 5, 6
```

### 5. Titik Dua (:)
**Untuk**: Superordinat dari deretan kata
```
WARNA: merah, biru, hijau
     ↑
   Titik dua
```

**Dalam database**:
```php
// Row superordinat
is_superordinate = true
description = 'WARNA'
word_order = 0
lemma_id = NULL

// Row kata-kata
meaning_group = 1 (sama dengan superordinat)
word_order = 1, 2, 3
```

### 6. Tanda Kurung ()
**Untuk**: Label ragam, bentuk pilihan, penjelasan
```
cepat (ragam cakapan)
atau (bentuk pilihan)
waktu (penjelasan)
```

**Dalam database**:
```php
language_variant = 'cak'  // Akan ditampilkan sebagai "ragam cakapan"
```

---

## 🔄 Alur Data dan Proses

### Proses 1: Input Data Artikel Baru

```
┌─────────────────────┐
│ Admin Input Artikel │
└──────────┬──────────┘
           │
           ▼
    ┌─────────────────┐
    │ Buat Article    │
    │ (Judul, Slug)   │
    └────────┬────────┘
             │
             ▼
    ┌──────────────────────┐
    │ Input Paragraf & Kata│
    │ Tentukan:            │
    │ - Superordinat?      │
    │ - Meaning Group      │
    │ - Ragam Bahasa       │
    │ - Acuan Lain?        │
    └────────┬─────────────┘
             │
             ▼
    ┌──────────────────────┐
    │ Simpan WordRelation  │
    │ dengan Struktur      │
    │ Paragraf Lengkap     │
    └──────────┬───────────┘
               │
               ▼
    ┌──────────────────────────┐
    │ System Smart Sort:       │
    │ - Abjad untuk kata biasa │
    │ - Waktu untuk bulan      │
    │ - Jenjang untuk pangkat  │
    └──────────────────────────┘
```

### Proses 2: Menampilkan Artikel

```
┌──────────────────────┐
│  User Buka Halaman   │
│  Lemma (cepat)       │
└──────────┬───────────┘
           │
           ▼
    ┌─────────────────────────────┐
    │ Query Article dengan        │
    │ WordRelation yang Terurut   │
    └──────────┬──────────────────┘
               │
               ▼
    ┌───────────────────────────────┐
    │ Blade Component Render:       │
    │ - Format Judul (Cetak Tebal)  │
    │ - Superordinat dengan ':'     │
    │ - Sinonim dengan ','          │
    │ - Nuansa Berbeda dengan ';'   │
    │ - Ragam Bahasa dalam ()       │
    │ - Acuan Lain sebagai Link     │
    └───────────────┬───────────────┘
                    │
                    ▼
        ┌──────────────────────┐
        │ Tampil di Halaman    │
        │ dengan Formatting    │
        │ Lengkap              │
        └──────────────────────┘
```

### Proses 3: Smart Sort

```
Input: ['Desember', 'Januari', 'Mei', 'Maret']

    ▼
┌────────────────────────────────┐
│ TesaurusFormatter::smartSort() │
└────────┬───────────────────────┘
         │
         ▼
    ┌─────────────────────┐
    │ Deteksi Jenis:      │
    │ Apakah bulan?       │
    │ Apakah hari?        │
    │ Apakah pangkat?     │
    │ Abjad normal?       │
    └────────┬────────────┘
             │
             ▼
    ┌──────────────────────────┐
    │ Bulan → Sort by Order    │
    │ Waktu (Januari=1, ...    │
    │ Desember=12)             │
    └────────┬─────────────────┘
             │
             ▼
Output: ['Januari', 'Maret', 'Mei', 'Desember']
```

---

## 💾 Contoh Data di Database

### Contoh: Artikel "CEPAT"

```sql
-- Article
INSERT INTO article VALUES
(523, 20, 1, 1, 'CEPAT', 'cepat');

-- Word Relations
INSERT INTO word_relation 
(article_id, lemma_id, par_num, meaning_group, wordclass_id, type_id, 
 is_superordinate, is_bold, description, word_order, language_variant)
VALUES

-- Row 1: Superordinat
(523, NULL, 1, 1, 1, 1, 1, 0, 'GERAK CEPAT', 0, NULL),

-- Row 2-5: Sinonim Grup 1 (separator: koma)
(523, 5,    1, 1, 1, 1, 0, 0, NULL, 1, NULL),  -- cepat
(523, 6,    1, 1, 1, 1, 0, 0, NULL, 2, NULL),  -- kilat
(523, 7,    1, 1, 1, 1, 0, 0, NULL, 3, NULL),  -- gesit
(523, 8,    1, 1, 1, 1, 0, 0, NULL, 4, NULL),  -- segera

-- Row 6-7: Sinonim Grup 2 (separator: titik koma)
(523, 9,    1, 2, 1, 1, 0, 0, NULL, 5, NULL),  -- lekas
(523, 10,   1, 2, 1, 1, 0, 0, NULL, 6, NULL),  -- deras

-- Row 8-9: Sinonim Grup 3 (separator: titik koma)
(523, 11,   1, 3, 1, 1, 0, 0, NULL, 7, NULL),  -- melesat
(523, 12,   1, 3, 1, 1, 0, 0, NULL, 8, 'cak'); -- terbang (ragam cakapan)
```

### Tampilan di Halaman

```
GERAK CEPAT: cepat, kilat, gesit, segera; lekas, deras; melesat, terbang (ragam cakapan)
```

**Penjelasan Formatting**:
- `GERAK CEPAT:` → Superordinat dengan cetak tebal dan titik dua
- `cepat, kilat, gesit, segera` → Sinonim grup 1, dipisah koma
- `;` → Pemisah antar grup makna
- `lekas, deras` → Sinonim grup 2 (nuansa berbeda), dipisah koma
- `;` → Pemisah antar grup makna
- `melesat, terbang` → Sinonim grup 3
- `(ragam cakapan)` → Label untuk ragam bahasa

---

## 🛠️ Tools dan Helper

### TesaurusFormatter Helper

Lokasi: `app/Helpers/TesaurusFormatter.php`

```php
// Import di Controller
use App\Helpers\TesaurusFormatter;

// Cara Penggunaan
$formatter = new TesaurusFormatter();

// Smart sort otomatis
$sorted = $formatter->smartSort($words);

// Sort spesifik
$formatter->sortAlphabetically($words);
$formatter->sortMonths($months);
$formatter->sortDays($days);
$formatter->sortMilitaryRanks($ranks);

// Format teks
$formatter->bold('JUDUL');
$formatter->italic('kata asing');
$formatter->languageVariant('cak', 'kata');
$formatter->superordinate('WARNA', ['merah', 'biru']);
```

---

## 📁 File-file Penting

### Migrasi Database
- `database/migrations/2026_02_04_050035_add_paragraph_fields_to_word_relation.php`
- `database/migrations/2026_02_04_050228_make_lemma_id_nullable_in_word_relation.php`

### Model
- `app/Models/Article.php`
- `app/Models/WordRelation.php` (UTAMA)
- `app/Models/Lemma.php`
- `app/Models/LabelType.php`
- `app/Models/Category.php`
- `app/Models/Subcategory.php`

### Helper
- `app/Helpers/TesaurusFormatter.php`

### Blade Components
- `resources/views/components/article-paragraph.blade.php`
- `resources/views/components/lemma-display.blade.php`

### Seeder
- `database/seeders/LabelTypeSeeder.php`
- `database/seeders/TesaurusSampleDataSeeder.php`

### Dokumentasi
- `PETUNJUK_IMPLEMENTASI_DATA.md` - Panduan lengkap
- `CONTOH_IMPLEMENTASI_API.md` - Contoh kode

---

## ✅ Checklist Implementasi

- ✅ Database schema dengan kolom paragraph
- ✅ Model dan relasi
- ✅ Label types (sinonimi, hiponimi, meronimi, antonimi)
- ✅ TesaurusFormatter helper
- ✅ Blade components untuk rendering
- ✅ Smart sort untuk berbagai jenis urutan
- ✅ Support ragam bahasa (cak, kas, hor)
- ✅ Support kata asing (foreign language)
- ✅ Support superordinat
- ✅ Support acuan ke artikel lain (is_bold)
- ✅ Sample data seeder
- ✅ Unit tests
- ✅ Dokumentasi lengkap

---

## 🧪 Testing

Jalankan test:
```bash
php artisan test tests/Feature/TesaurusFormattingTest.php
```

---

## 🚀 Cara Menggunakan

### 1. Menampilkan Lemma dengan Paragraf
```php
// Di controller
$lemma = Lemma::with([
    'wordRelations' => function($q) {
        $q->with(['relationshipType', 'article'])
          ->orderBy('par_num')
          ->orderBy('meaning_group')
          ->orderBy('word_order');
    }
])->where('name', 'cepat')->first();

return view('lemma', compact('lemma', 'formatter'));
```

### 2. Di Blade Template
```blade
<x-lemma-display :lemma="$lemma" :relations="$lemma->wordRelations" />
```

### 3. Menambah Data Baru
```php
// Lihat CONTOH_IMPLEMENTASI_API.md bagian "Membuat Artikel Baru"
```

---

## 📞 Support

Untuk pertanyaan atau perubahan, lihat:
- `PETUNJUK_IMPLEMENTASI_DATA.md` - Panduan detail
- `CONTOH_IMPLEMENTASI_API.md` - Contoh implementasi
- `tests/Feature/TesaurusFormattingTest.php` - Test cases

---

**Status**: ✅ Siap Digunakan
**Versi**: 1.0
**Last Updated**: 4 Februari 2026
