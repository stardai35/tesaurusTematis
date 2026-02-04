# Panduan Implementasi Data Tesaurus Tematis

Dokumentasi ini menjelaskan bagaimana struktur data Tesaurus Tematis Bahasa Indonesia diimplementasikan sesuai dengan petunjuk penggunaan dari Badan Pengembangan dan Pembinaan Bahasa.

## Struktur Data

### 1. Artikel dan Bidang Ilmu

- **Kategori (Category)**: Bidang besar ilmu (misalnya: Seni, Olahraga, Hukum, dll)
- **Subkategori (Subcategory)**: Pembagian lebih rinci dari kategori
- **Artikel (Article)**: Judul artikel yang memuat kata-kata saling bertalian (direncanakan 522 artikel)

### 2. Kata dan Lemma

- **Lemma**: Kata atau satuan leksikal dasar
- **Label (Label)**: Jenis kata (nomina, verba, adjektiva, dll)
- **WordClass**: Kelas kata yang lebih detail (Nomina, Verba, Adjektiva, Adverbia, Konjungsi, Numeralia, Partikel)

### 3. Relasi Kata (WordRelation)

Menghubungkan lemma dengan artikel dan menyimpan informasi struktural:

```
word_relation
├── article_id          : Artikel yang memuat lemma
├── lemma_id            : Kata yang dimuat
├── par_num             : Nomor paragraf (1, 2, 3, ...)
├── meaning_group       : Kelompok makna dalam paragraf
├── wordclass_id        : Kelas kata
├── type_id             : Tipe hubungan (dari tabel type)
├── relationship_type   : Jenis relasi makna (sinonimi, hiponimi, meronimi)
├── word_order          : Urutan kata dalam paragraf
├── is_superordinate    : Menandai jika kata adalah superordinat
├── is_bold             : Menandai acuan ke artikel lain (dicetak tebal)
├── language_variant    : Ragam bahasa (cak=cakapan, kas=kasar, hor=hormat)
├── foreign_language    : Bahasa asing jika ada (untuk cetak miring)
└── description         : Penjelasan atau deskripsi kata
```

## Aturan Ortografi dan Sistem Ortografi

### 1. Cetak Tebal dan Huruf Kapital

**Penggunaan**: Menandai judul artikel

```
SUPERORDINAT, SINONIM1, SINONIM2
```

**Untuk acuan ke artikel lain**: Cetak tebal dengan link

```html
<a href="{{ route('lemma', ['slug' => $slug]) }}" class="article-reference">
    <strong>{{ strtoupper($title) }}</strong>
</a>
```

### 2. Cetak Miring

**Penggunaan**: Penjelasan kata asing

```blade
<span class="foreign-text">{{ $lemmaName }}</span>
```

### 3. Tanda Baca dan Fungsinya

#### Koma (,)
Memisahkan kata dengan hubungan makna **SAMA**:
- Sinonimi: `cepat, kilat, gesit`
- Hiponimi: `bunga, mawar, tulip`
- Meronimi: `mobil, roda, mesin`

#### Titik Koma (;)
Memisahkan kelompok kata dengan nuansa makna **BERBEDA** tapi masih dekat

```
cepat, kilat, gesit; lekas, deras, segera
```

#### Titik Dua (:)
Menandai superordinat dari deretan kata yang mengikutinya

```
WARNA: merah, biru, hijau, kuning
```

#### Tanda Hubung (-)
Menandai bentuk terikat

```
-lah, -kah, -nya
```

#### Tanda Kurung ()
Untuk label ragam, bentuk pilihan, atau penjelasan

```
cepat (ragam cakapan)
atau (bentuk pilihan)
waktu (satuan ukuran)
```

## Cara Mengisi Data

### 1. Menambah Lemma dengan Ragam Bahasa

```php
$wordRelation = WordRelation::create([
    'article_id' => 1,
    'lemma_id' => 5,
    'par_num' => 1,
    'meaning_group' => 1,
    'wordclass_id' => 1,
    'type_id' => 1,
    'relationship_type' => 1, // ID dari label_type (sinonimi)
    'word_order' => 1,
    'is_superordinate' => false,
    'is_bold' => false,
    'language_variant' => 'cak', // cak, kas, atau hor
    'foreign_language' => null,
    'description' => null,
]);
```

### 2. Menambah Superordinat

```php
$wordRelation = WordRelation::create([
    'article_id' => 1,
    'lemma_id' => null,
    'par_num' => 1,
    'meaning_group' => 1,
    'is_superordinate' => true,
    'description' => 'WARNA', // Akan menjadi "WARNA:"
    'word_order' => 0,
]);

// Kemudian tambah kata-kata yang termasuk dalam superordinat dengan
// meaning_group yang sama
```

### 3. Menambah Acuan ke Artikel Lain

```php
$wordRelation = WordRelation::create([
    // ... field lainnya
    'is_bold' => true, // Akan ditampilkan dengan link
    // ... field lainnya
]);
```

### 4. Menambah Kata Asing

```php
$wordRelation = WordRelation::create([
    // ... field lainnya
    'foreign_language' => 'English: quick',
    // Akan ditampilkan dalam cetak miring
]);
```

## Helper Class: TesaurusFormatter

Gunakan helper `App\Helpers\TesaurusFormatter` untuk berbagai formatting:

```php
use App\Helpers\TesaurusFormatter;

// Format cetak tebal
TesaurusFormatter::bold('JUDUL')

// Format cetak miring (kata asing)
TesaurusFormatter::italic('word')

// Format label ragam
TesaurusFormatter::languageVariant('cak', 'kata')

// Format superordinat
TesaurusFormatter::superordinate('WARNA', ['merah', 'biru', 'hijau'])

// Smart sort (otomatis deteksi jenis urutan)
$sorted = TesaurusFormatter::smartSort($words);

// Sort khusus:
TesaurusFormatter::sortAlphabetically($words)    // A-Z
TesaurusFormatter::sortMonths($words)            // Jan-Dec
TesaurusFormatter::sortDays($words)              // Min-Sab
TesaurusFormatter::sortMilitaryRanks($words)     // Jenjang militer
```

## Komponen Blade untuk Menampilkan

### 1. Article Paragraph Component

```blade
<x-article-paragraph :wordRelations="$relations" :formatter="$formatter" />
```

Menampilkan paragraf dengan format ortografi yang benar.

### 2. Lemma Display Component

```blade
<x-lemma-display :lemma="$lemma" :relations="$relations" :formatter="$formatter" />
```

Menampilkan lemma dengan judul, label, dan paragraf.

## Database Query Examples

### Mendapatkan Semua Sinonim

```php
$synonyms = WordRelation::where('article_id', $articleId)
    ->where('relationship_type', 1) // ID sinonimi
    ->with(['lemma', 'relationshipType'])
    ->get();
```

### Mendapatkan Semua Kata dalam Artikel dengan Urutan

```php
$relations = WordRelation::where('article_id', $articleId)
    ->with(['lemma', 'relationshipType'])
    ->orderBy('par_num', 'asc')
    ->orderBy('meaning_group', 'asc')
    ->orderBy('word_order', 'asc')
    ->get();
```

### Mencari Lemma dengan Variasi Bahasa

```php
$cakapanWords = WordRelation::where('language_variant', 'cak')
    ->with(['lemma', 'article'])
    ->get();
```

## Contoh Data Lengkap

### Artikel: CEPAT

**Paragraph 1:**
```
GERAK CEPAT: cepat, kilat, gesit, segera; lekas, deras; melesat, terbang

Ragam cakapan: (cepat dengan kecepatan tinggi)
Ragam kasar: (bergerak dengan sangat melesat)
```

**Dalam Database:**

| id | article_id | lemma_id | par_num | meaning_group | relationship_type | is_superordinate | is_bold | language_variant | word_order |
|----|-----------|----------|---------|---------------|------------------|------------------|---------|------------------|-----------|
| 1  | 1         | null     | 1       | 1             | null             | true             | false   | null             | 0         |
| 2  | 1         | 5        | 1       | 1             | 1                | false            | false   | null             | 1         |
| 3  | 1         | 6        | 1       | 1             | 1                | false            | false   | null             | 2         |
| 4  | 1         | 7        | 1       | 1             | 1                | false            | false   | null             | 3         |
| 5  | 1         | 8        | 1       | 2             | 1                | false            | false   | null             | 4         |
| 6  | 1         | 5        | 1       | 1             | null             | false            | false   | cak              | 5         |

## Catatan Penting

1. **Smart Sorting**: Sistem otomatis mendeteksi jenis kata dan mengurutkan dengan tepat:
   - Abjad normal untuk kata biasa
   - Waktu untuk bulan (Januari, Februari, ...)
   - Hari (Minggu, Senin, ...)
   - Jenjang untuk pangkat militer

2. **Relasi Makna**: Gunakan relationship_type untuk menandai jenis hubungan:
   - Sinonimi: makna sama/mirip
   - Hiponimi: makna lebih sempit (bunga → mawar)
   - Meronimi: bagian dari (mobil → roda)
   - Antonimi: makna berlawanan

3. **Formatting**: Semua formatting otomatis dilakukan oleh sistem, cukup atur flag `is_bold`, `is_superordinate`, dll.

4. **Performa Query**: Selalu include relationships yang dibutuhkan dengan `with()` untuk menghindari N+1 query problem.

## Testing

```php
// Cek migration berhasil
php artisan migrate

// Seed label_type
php artisan db:seed --class=LabelTypeSeeder

// Akses di browser
http://localhost/tesatema/
```

---

**Sumber**: 
- https://tesaurus.kemendikdasmen.go.id/tematis/petunjuk_penggunaan
- Tesaurus Tematis Bahasa Indonesia - Badan Pengembangan dan Pembinaan Bahasa
