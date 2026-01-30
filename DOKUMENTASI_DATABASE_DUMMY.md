# Dokumentasi Database Dummy Tesaurus

## Ringkasan
Database dummy telah berhasil dibuat untuk website Tesaurus dengan struktur data yang lengkap dan sesuai dengan parameter yang ada.

## Data yang Telah Dibuat

### 1. **Label (Ragam Kata)** 
Sudah ada dari seeder sebelumnya:
- Nomina (n)
- Verba (v)
- Adjektiva (a)
- Adverbia (adv)
- Numeralia (num)
- Pronomina (pron)

Ditambah dari sampel SQL:
- (ragam) cakapan (cak)
- (ragam) kasar (kas)
- (ragam) hormat (hor)
- Kiasan (ki)
- Arkais (ark)
- Klasik (kl)

### 2. **Word Class (Kelas Kata)**
- Adjektiva (a) - Kata sifat
- Adverbia (adv) - Kata keterangan
- Konjungsi (konj) - Kata hubung
- Nomina (n) - Kata benda
- Numeralia (num) - Kata bilangan
- Partikel (p) - Kata partikel
- Verba (v) - Kata kerja

### 3. **Type (Jenis Relasi)**
- Sinonim - Kata yang memiliki makna sama atau mirip
- Antonim - Kata yang berlawanan makna
- Contoh - Kata yang menjadi contoh
- Kata_terkait - Kata yang berhubungan

### 4. **Category & Subcategory**
Menggunakan FullCategorySeeder yang sudah ada, dengan 12 kategori dan 40 subkategori sesuai struktur tesaurus Indonesia.

### 5. **Lemma (310 kata)**

#### Kata Kerja (Verba) - 50 kata
Contoh: makan, minum, tidur, bangun, berjalan, berlari, melompat, menulis, membaca, belajar, mengajar, bekerja, bermain, bernyanyi, menari, dll.

Termasuk ragam cakapan:
- ngomong (cak)
- makan-makan (cak)
- nongkrong (cak)

Termasuk kiasan:
- memakan hati (ki)
- menelan ludah (ki)
- membanting tulang (ki)

#### Kata Benda (Nomina) - 150+ kata

**Tempat dan Bangunan:**
rumah, sekolah, kantor, pasar, toko, restoran, hotel, jalan, jembatan, gedung, bangunan

**Kendaraan:**
mobil, motor, sepeda, bus, kereta api, pesawat, kapal, perahu

**Peralatan:**
buku, majalah, koran, surat, pensil, pulpen, kertas, meja, kursi, tempat tidur, lemari, pintu, jendela, lampu, televisi, komputer, telepon, handphone

**Makanan dan Minuman:**
nasi, roti, mie, sayur, buah, daging, ikan, ayam, telur, susu, kopi, teh, air, jus

**Profesi:**
guru, dosen, dokter, perawat, polisi, tentara, pengusaha, petani, nelayan, pedagang, karyawan, pegawai, direktur, manajer, sekretaris, programmer, desainer, arsitek, insinyur, peneliti, ilmuwan, seniman, musisi, penyanyi, penari, pelukis, penulis, jurnalis, wartawan

**Keluarga:**
ayah, ibu, kakak, adik, kakek, nenek, paman, bibi, sepupu, suami, istri, anak, cucu

**Alam dan Lingkungan:**
- Benda Langit: matahari, bulan, bintang, langit, awan
- Cuaca: hujan, angin, petir, guntur, pelangi
- Bentang Alam: gunung, bukit, lembah, sungai, danau, laut, pantai, hutan
- Tumbuhan: pohon, bunga, rumput
- Material: tanah, batu, pasir

**Hewan:**
kucing, anjing, burung, sapi, kerbau, kambing, domba, kuda, harimau, singa, gajah, monyet, ular, katak, kelinci, tikus

**Waktu:**
hari, minggu, bulan, tahun, pagi, siang, sore, malam, kemarin, hari ini, besok, lusa, dulu, sekarang, nanti

#### Kata Sifat (Adjektiva) - 60+ kata

**Ukuran:**
besar, kecil, panjang, pendek, tinggi, rendah, luas, sempit, tebal, tipis, berat, ringan

**Penampilan:**
cantik, tampan, jelek, indah, buruk

**Karakter:**
baik, jahat, pintar, bodoh, rajin, malas, berani, penakut, sabar

**Kecepatan:**
cepat, lambat

**Suhu:**
panas, dingin, hangat, sejuk

**Cahaya:**
terang, gelap

**Keramaian:**
ramai, sepi

**Tekstur:**
keras, lembut, kasar, halus

**Kekuatan:**
kuat, lemah

**Emosi:**
marah, senang, sedih, gembira, murung

**Warna:**
merah, kuning, hijau, biru, putih, hitam, coklat, ungu, pink, orange, abu-abu

#### Kata Bilangan (Numeralia) - 20 kata
satu, dua, tiga, empat, lima, enam, tujuh, delapan, sembilan, sepuluh, sebelas, dua belas, seratus, seribu, sejuta, pertama, kedua, ketiga

#### Kata Keterangan (Adverbia) - 15 kata
sangat, terlalu, agak, sedikit, banyak, selalu, sering, kadang-kadang, jarang, tidak pernah, sudah, belum, sedang, akan

#### Kata Hubung (Konjungsi) - 15 kata
dan, atau, tetapi, namun, karena, sebab, jika, kalau, ketika, saat, sebelum, sesudah, setelah, supaya, agar, meskipun, walaupun, sehingga

### 6. **Article (10 Artikel Tematik)**

1. **Angka dan Bilangan** - Berisi kata bilangan dasar
2. **Kegiatan Sehari-hari** - Berisi kata kerja aktivitas harian
3. **Sifat dan Keadaan** - Berisi kata sifat dengan 2 grup (Ukuran & Berat)
4. **Anggota Keluarga** - Berisi kata benda tentang keluarga
5. **Emosi dan Perasaan** - Berisi kata sifat tentang emosi
6. **Profesi dan Pekerjaan** - Berisi kata benda tentang pekerjaan
7. **Alam dan Lingkungan** - Berisi kata benda tentang alam (2 paragraf: Benda Langit & Bentang Alam)
8. **Hewan** - Berisi kata benda tentang hewan
9. **Warna** - Berisi kata sifat tentang warna
10. **Komunikasi** - Berisi kata kerja tentang komunikasi

### 7. **Word Relation (Relasi Kata)**

Setiap artikel memiliki word_relation yang menghubungkan artikel dengan lemma, dengan atribut:
- `article_id` - ID artikel
- `par_num` - Nomor paragraf dalam artikel
- `wordclass_id` - ID kelas kata (1-7)
- `group_num` - Nomor grup dalam paragraf
- `type_id` - Tipe relasi (1=ordinary lemma, 2=article title, 3=superordinate)
- `word_order` - Urutan kata dalam grup
- `lemma_id` - ID lemma yang terkait

## Struktur Relasi

```
Category (12 kategori)
  └── Subcategory (40 subkategori)
        └── Article (10 artikel dummy)
              └── Word_Relation
                    ├── Word_Class (7 kelas kata)
                    ├── Type (4 tipe relasi)
                    └── Lemma (310 kata)
                          └── Label (6 label ragam)
```

## Cara Menggunakan

### Menjalankan Semua Seeder
```bash
php artisan migrate:fresh --seed
```

### Menjalankan Seeder Spesifik
```bash
# Label, Word Class, Type, Category (basic)
php artisan db:seed

# Kategori lengkap
php artisan db:seed --class=FullCategorySeeder

# Lemma (310 kata)
php artisan db:seed --class=LemmaSeeder

# Article dan Word Relation
php artisan db:seed --class=ArticleAndRelationSeeder
```

### Urutan Seeder yang Benar
1. DatabaseSeeder (basic data: label, word_class, type)
2. FullCategorySeeder (category & subcategory)
3. LemmaSeeder (310 kata)
4. ArticleAndRelationSeeder (10 artikel + relasi)

## Fitur yang Dapat Diuji

### 1. Pencarian Kata (Search)
Website dapat mencari dari 310 lemma yang ada, misalnya:
- Cari "makan" → akan muncul di artikel "Kegiatan Sehari-hari"
- Cari "merah" → akan muncul di artikel "Warna"
- Cari "guru" → akan muncul di artikel "Profesi dan Pekerjaan"

### 2. Browsing Kategori
- Browse kategori → pilih subkategori → lihat artikel
- Contoh: Kategori 1 → Subkategori 1 (Bilangan) → Artikel "Angka dan Bilangan"

### 3. Melihat Detail Artikel
- Setiap artikel menampilkan kata-kata terkait yang dikelompokkan berdasarkan:
  - Paragraf (par_num)
  - Grup (group_num)
  - Kelas kata (word_class)
  
### 4. Relasi Kata
- Setiap kata dalam artikel memiliki urutan (word_order)
- Kata dapat dikelompokkan berdasarkan makna/tema dalam satu artikel
- Contoh: Artikel "Sifat dan Keadaan" memiliki 2 grup:
  - Grup 1: Ukuran (besar, kecil, panjang, pendek, tinggi, rendah)
  - Grup 2: Berat (berat, ringan, tebal, tipis)

### 5. Label/Ragam Kata
- Beberapa kata memiliki label khusus:
  - Cakapan (cak): ngomong, nongkrong, makan-makan
  - Kiasan (ki): memakan hati, menelan ludah, membanting tulang
  
## Catatan Pengembangan

### Untuk Menambah Data:
1. **Tambah Lemma**: Edit `LemmaSeeder.php` dan tambahkan kata baru ke array `$lemmas`
2. **Tambah Artikel**: Edit `ArticleAndRelationSeeder.php` dan buat artikel baru dengan relasi kata
3. **Tambah Kategori**: Edit `FullCategorySeeder.php` untuk menambah kategori/subkategori baru

### Validasi Data:
```bash
# Cek jumlah data
php artisan tinker
> DB::table('lemma')->count();      // 310
> DB::table('article')->count();    // 10
> DB::table('word_relation')->count(); // ~100
> DB::table('category')->count();   // 12
> DB::table('subcategory')->count(); // 40
```

## Kesimpulan

Database dummy ini menyediakan fondasi yang kuat untuk pengembangan website tesaurus dengan:
- **310 lemma** yang mencakup berbagai kelas kata
- **10 artikel tematik** dengan relasi kata yang terstruktur
- **Ragam kata** yang bervariasi (standar, cakapan, kiasan)
- **Struktur hierarkis** yang jelas (kategori → subkategori → artikel → lemma)
- **Relasi kata** yang terorganisir dengan baik (paragraf, grup, urutan)

Data ini sudah cukup untuk menguji semua fitur utama website tesaurus dan dapat dengan mudah diperluas sesuai kebutuhan.
