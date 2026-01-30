<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleAndRelationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Pastikan ada kategori dan subkategori terlebih dahulu
        // Seeder ini bergantung pada FullCategorySeeder
        
        // Hapus artikel lama jika ada dengan disable foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('word_relation')->delete();
        DB::table('article')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Ambil beberapa lemma untuk dijadikan relasi
        $lemmas = DB::table('lemma')->limit(100)->get();
        
        if ($lemmas->isEmpty()) {
            $this->command->warn('Tidak ada data lemma. Jalankan LemmaSeeder terlebih dahulu.');
            return;
        }
        
        // Artikel 1: Bilangan (Category 1, Subcategory 1)
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 1,
            'subcat_id' => 1,
            'num' => 1,
            'title' => 'Angka dan Bilangan',
            'slug' => 'angka-dan-bilangan',
        ]);
        
        // Tambahkan word relations untuk artikel Bilangan
        $bilanganWords = ['satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh'];
        $wordOrder = 1;
        foreach ($bilanganWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 5, // Numeralia
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 2: Kegiatan Sehari-hari
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 1,
            'subcat_id' => 2,
            'num' => 2,
            'title' => 'Kegiatan Sehari-hari',
            'slug' => 'kegiatan-sehari-hari',
        ]);
        
        // Tambahkan word relations untuk artikel Kegiatan
        $kegiatanWords = ['makan', 'minum', 'tidur', 'bangun', 'berjalan', 'berlari', 'bekerja', 'bermain'];
        $wordOrder = 1;
        foreach ($kegiatanWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 7, // Verba
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 3: Sifat dan Keadaan
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 1,
            'subcat_id' => 3,
            'num' => 3,
            'title' => 'Sifat dan Keadaan',
            'slug' => 'sifat-dan-keadaan',
        ]);
        
        // Grup 1: Ukuran
        $ukuranWords = ['besar', 'kecil', 'panjang', 'pendek', 'tinggi', 'rendah'];
        $wordOrder = 1;
        foreach ($ukuranWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 1, // Adjektiva
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Grup 2: Berat
        $beratWords = ['berat', 'ringan', 'tebal', 'tipis'];
        $wordOrder = 1;
        foreach ($beratWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 1, // Adjektiva
                    'group_num' => 2,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 4: Keluarga
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 10,
            'subcat_id' => 30,
            'num' => 4,
            'title' => 'Anggota Keluarga',
            'slug' => 'anggota-keluarga',
        ]);
        
        $keluargaWords = ['ayah', 'ibu', 'kakak', 'adik', 'kakek', 'nenek', 'paman', 'bibi', 'suami', 'istri', 'anak', 'cucu'];
        $wordOrder = 1;
        foreach ($keluargaWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 4, // Nomina
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 5: Emosi dan Perasaan
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 9,
            'subcat_id' => 24,
            'num' => 5,
            'title' => 'Emosi dan Perasaan',
            'slug' => 'emosi-dan-perasaan',
        ]);
        
        $emosiWords = ['senang', 'sedih', 'gembira', 'murung', 'marah', 'sabar'];
        $wordOrder = 1;
        foreach ($emosiWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 1, // Adjektiva
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 6: Profesi
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 10,
            'subcat_id' => 28,
            'num' => 6,
            'title' => 'Profesi dan Pekerjaan',
            'slug' => 'profesi-dan-pekerjaan',
        ]);
        
        $profesiWords = ['guru', 'dokter', 'polisi', 'petani', 'nelayan', 'pedagang', 'pengusaha', 'karyawan'];
        $wordOrder = 1;
        foreach ($profesiWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 4, // Nomina
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 7: Alam dan Lingkungan
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 1,
            'subcat_id' => 3,
            'num' => 7,
            'title' => 'Alam dan Lingkungan',
            'slug' => 'alam-dan-lingkungan',
        ]);
        
        // Grup 1: Benda Langit
        $langitWords = ['matahari', 'bulan', 'bintang', 'langit', 'awan'];
        $wordOrder = 1;
        foreach ($langitWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 4, // Nomina
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Grup 2: Bentang Alam
        $alamWords = ['gunung', 'bukit', 'lembah', 'sungai', 'danau', 'laut', 'pantai', 'hutan'];
        $wordOrder = 1;
        foreach ($alamWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 2,
                    'wordclass_id' => 4, // Nomina
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 8: Hewan
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 4,
            'subcat_id' => 9,
            'num' => 8,
            'title' => 'Hewan',
            'slug' => 'hewan',
        ]);
        
        $hewanWords = ['kucing', 'anjing', 'burung', 'sapi', 'kerbau', 'kambing', 'kuda', 'gajah', 'monyet'];
        $wordOrder = 1;
        foreach ($hewanWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 4, // Nomina
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 9: Warna
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 1,
            'subcat_id' => 3,
            'num' => 9,
            'title' => 'Warna',
            'slug' => 'warna',
        ]);
        
        $warnaWords = ['merah', 'kuning', 'hijau', 'biru', 'putih', 'hitam', 'coklat', 'ungu', 'pink', 'orange'];
        $wordOrder = 1;
        foreach ($warnaWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 1, // Adjektiva
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        // Artikel 10: Komunikasi
        $articleId = DB::table('article')->insertGetId([
            'cat_id' => 11,
            'subcat_id' => 34,
            'num' => 10,
            'title' => 'Komunikasi',
            'slug' => 'komunikasi',
        ]);
        
        $komunikasiWords = ['berbicara', 'menulis', 'membaca', 'mendengar', 'melihat'];
        $wordOrder = 1;
        foreach ($komunikasiWords as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => 7, // Verba
                    'group_num' => 1,
                    'type_id' => 1, // ordinary lemma
                    'word_order' => $wordOrder++,
                    'lemma_id' => $lemma->id,
                ]);
            }
        }
        
        $this->command->info('Berhasil menambahkan 10 artikel dengan relasi kata.');
    }
}
