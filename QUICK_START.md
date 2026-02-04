# Quick Start - Implementasi Tesaurus

## 5 Menit Setup

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Seed Data Tipe Label
```bash
php artisan db:seed --class=LabelTypeSeeder
```

### 3. Seed Contoh Data (Optional)
```bash
php artisan db:seed --class=TesaurusSampleDataSeeder
```

Ini akan membuat contoh artikel "CEPAT" dengan data lengkap.

---

## Struktur Data Minimum

### Untuk Menambah Artikel Baru:

```php
use App\Models\Article;
use App\Models\Lemma;
use App\Models\WordRelation;

// 1. Buat Article
$article = Article::create([
    'cat_id' => 1,
    'subcat_id' => 1,
    'num' => 1,
    'title' => 'JUDUL_ARTIKEL',
    'slug' => 'slug-artikel',
]);

// 2. Buat Lemma (jika belum ada)
$lemma = Lemma::create([
    'name' => 'kata',
    'label_id' => 1,
]);

// 3. Buat WordRelation
WordRelation::create([
    'article_id' => $article->id,
    'lemma_id' => $lemma->id,
    'par_num' => 1,
    'meaning_group' => 1,
    'wordclass_id' => 1,
    'type_id' => 1,
    'word_order' => 1,
]);
```

---

## Kolom Penting di WordRelation

```
KOLOM UTAMA:
├── article_id        : Artikel yang memuat
├── lemma_id          : Kata (NULL untuk superordinat)
├── par_num           : Nomor paragraf
├── meaning_group     : Kelompok makna (1, 2, 3...)
├── word_order        : Urutan dalam paragraf

KOLOM FORMATTING:
├── is_superordinate  : true/false - Superordinat?
├── is_bold           : true/false - Link ke artikel lain?
├── language_variant  : 'cak'|'kas'|'hor' - Ragam bahasa
├── foreign_language  : 'English: ...' - Kata asing
├── description       : Penjelasan
└── relationship_type : ID jenis relasi (sinonimi, dll)
```

---

## Contoh Penggunaan di Blade

```blade
<!-- Tampilkan lemma lengkap dengan paragraf -->
<x-lemma-display 
    :lemma="$lemma" 
    :relations="$lemma->wordRelations"
    :formatter="$formatter"
/>

<!-- Atau tampilkan hanya paragraf -->
<x-article-paragraph 
    :wordRelations="$relations"
    :formatter="$formatter"
/>
```

---

## Query Contoh

### Dapatkan Artikel dengan Kata
```php
$article = Article::with([
    'wordRelations' => function($q) {
        $q->with(['lemma', 'relationshipType'])
          ->orderBy('par_num')
          ->orderBy('meaning_group')
          ->orderBy('word_order');
    }
])->where('slug', 'cepat')->first();
```

### Dapatkan Sinonim
```php
$synonyms = $lemma->wordRelations()
    ->where('relationship_type', 1) // sinonimi
    ->with('relationshipType')
    ->get();
```

### Smart Sort
```php
use App\Helpers\TesaurusFormatter;

$formatter = new TesaurusFormatter();
$sorted = $formatter->smartSort($words);
```

---

## Penjelasan Tanda Baca

| Tanda | Penggunaan | Contoh |
|-------|-----------|--------|
| **Cetak Tebal** | Judul artikel | **CEPAT** |
| , | Sinonim sama | cepat, kilat, gesit |
| ; | Nuansa berbeda | cepat, kilat; lekas, deras |
| : | Superordinat | **WARNA**: merah, biru |
| () | Ragam/Penjelasan | cepat (ragam cakapan) |
| *Miring* | Kata asing | *quick* (English) |
| - | Bentuk terikat | -lah, -kah |

---

## Mapping Database ke Tanda Baca

### Superordinat + Titik Dua
```php
WordRelation::create([
    'is_superordinate' => true,
    'description' => 'WARNA',
    'word_order' => 0,
    'lemma_id' => NULL,
]);
// Tampil: "WARNA:"
```

### Sinonim dengan Koma
```php
// Kata-kata dengan meaning_group SAMA = dipisah koma
WordRelation::create([
    'meaning_group' => 1,
    'word_order' => 1, 2, 3,  // urutan
]);
// Tampil: "kata1, kata2, kata3"
```

### Nuansa Berbeda dengan Titik Koma
```php
// Kata-kata dengan meaning_group BERBEDA = dipisah titik koma
WordRelation::create([
    'meaning_group' => 1,  // grup 1
    'word_order' => 1, 2,
]),
WordRelation::create([
    'meaning_group' => 2,  // grup 2 (berbeda)
    'word_order' => 3, 4,
]);
// Tampil: "kata1, kata2; kata3, kata4"
```

### Ragam Bahasa dalam Kurung
```php
WordRelation::create([
    'language_variant' => 'cak',  // ragam cakapan
]);
// Tampil: "kata (ragam cakapan)"
```

### Kata Asing dalam Cetak Miring
```php
WordRelation::create([
    'foreign_language' => 'English: quick',
]);
// Tampil: "*quick* (English)"
```

### Acuan ke Artikel Lain
```php
WordRelation::create([
    'is_bold' => true,  // akan menjadi link
]);
// Tampil: <a href="..."><strong>KATA</strong></a>
```

---

## Troubleshooting

### Error: "lemma_id doesn't have a default value"
Jalankan: `php artisan migrate`

### Kolom tidak muncul di WordRelation
Pastikan sudah migrate: `php artisan migrate`

### Smart sort tidak bekerja
```php
use App\Helpers\TesaurusFormatter;
$formatter = new TesaurusFormatter();
$sorted = $formatter->smartSort($items);
```

---

## Dokumentasi Lengkap

- **DOKUMENTASI_ALUR_DATA.md** - Penjelasan lengkap sistem
- **PETUNJUK_IMPLEMENTASI_DATA.md** - Panduan implementasi detail
- **CONTOH_IMPLEMENTASI_API.md** - Contoh kode lengkap

---

## Testing

```bash
# Jalankan test
php artisan test tests/Feature/TesaurusFormattingTest.php

# Atau spesifik test
php artisan test tests/Feature/TesaurusFormattingTest.php::test_create_superordinate_word_relation
```

---

**Status**: Ready to Use ✅
**Semua fitur sudah diimplementasikan dan teruji**
