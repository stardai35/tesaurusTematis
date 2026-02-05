<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BilanganArticleSeeder extends Seeder
{
    /**
     * Run the database seeder untuk artikel Bilangan dengan word class lengkap
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Cek apakah artikel "bilangan" sudah ada
        $existingArticle = DB::table('article')
            ->where('slug', 'bilangan')
            ->first();

        if ($existingArticle) {
            // Hapus word relations lama
            DB::table('word_relation')->where('article_id', $existingArticle->id)->delete();
            $articleId = $existingArticle->id;
        } else {
            // Buat artikel baru
            $articleId = DB::table('article')->insertGetId([
                'cat_id' => 1,
                'subcat_id' => 1,
                'num' => 1,
                'title' => 'Bilangan',
                'slug' => 'bilangan',
            ]);
        }

        // ==================== VERBA (Kata Kerja) ====================
        $verbaWords = [
            'membilang',
            'menumeris',
            'menghitung',
            'menjumlahkan',
            'mengurangi',
            'mengalikan',
            'membagi',
            'menambahkan',
            'mengurangkan',
            'menghitung ulang',
            'mengingat bilangan',
        ];

        $this->insertWords($articleId, $verbaWords, 7); // wordclass_id = 7 untuk Verba

        // ==================== ADJEKTIVA (Kata Sifat) ====================
        $adjWords = [
            'desimal',
            'digital',
            'numerik',
            'numeris',
            'kuantitatif',
            'banyak',
            'jamak',
            'plural',
            'pluralis',
            'kardinal',
            'negatif',
            'positif',
        ];

        $this->insertWords($articleId, $adjWords, 1); // wordclass_id = 1 untuk Adjektiva

        // ==================== NOMINA (Kata Benda) ====================
        $nominaSubgroups = [
            'Dasar Bilangan' => [
                'cacah',
                'jumlah',
                'kuantitas',
                'total',
                'angka',
                'bilangan',
                'digit',
                'digit uji',
                'taktor',
                'kode',
                'sandi',
            ],
            'Jenis Bilangan' => [
                'fraksi (fraction)',
                'pecahan',
                'angka',
                'bilangan arab',
                'angka romawi',
                'angka arab romawi',
            ],
            'Kategori Bilangan' => [
                'cacah',
                'jurat',
                'kuartal',
                'kurtois',
                'kurta',
                'digi byte',
                'digit lanjut',
                'digit uji',
                'taktor (sub)',
                'kode angka (umum)',
                'sandi (khusus)',
            ],
            'Pembilang & Penyebut' => [
                'perlilangan',
                'pemenilician',
                'pencacahan',
                'penghitungan',
                'penggolongan',
                'penyenjanikan',
                'pembulatkan',
                'pembulatan (khusus)',
                'pembilang',
                'bilangan (umum)',
                'bilangan (khusus)',
                'evaluasi',
                'penilaian',
            ],
            'Operasi Bilangan' => [
                'penjumlahan',
                'pemenilician',
                'pencacahan',
                'penghitungan',
                'penggolongan',
                'penyenjanikan',
                'pembulatkan',
                'pembulatan (khusus)',
                'pembilang',
                'bilangan (umum)',
                'bilangan (khusus)',
                'evaluasi',
                'penilaian bilangan',
                'estimasi',
                'penaksiran',
                'periksa',
                'perihalan',
                'perihalan bilangan',
            ],
            'Satuan & Ukuran' => [
                'ajizab',
                'aritmerika',
                'ilmu hitung',
                'materialika',
                'statistika',
                'angka',
                'anggal',
                'angka',
                'angka',
                'angka cetak (kamus)',
                'tunggal (satu)',
                'surrogat (ganti)',
            ],
        ];

        $wordOrder = 1;
        foreach ($nominaSubgroups as $groupName => $words) {
            foreach ($words as $word) {
                $lemma = DB::table('lemma')->where('name', $word)->first();
                if ($lemma) {
                    DB::table('word_relation')->insert([
                        'article_id' => $articleId,
                        'par_num' => 1,
                        'wordclass_id' => 4, // Nomina
                        'group_num' => $wordOrder,
                        'type_id' => 1,
                        'word_order' => $wordOrder,
                        'lemma_id' => $lemma->id,
                    ]);
                    $wordOrder++;
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Seeder Artikel Bilangan berhasil dijalankan!');
    }

    /**
     * Helper function untuk insert words
     */
    private function insertWords($articleId, $words, $wordclassId)
    {
        $wordOrder = 1;
        foreach ($words as $word) {
            $lemma = DB::table('lemma')->where('name', $word)->first();
            if ($lemma) {
                DB::table('word_relation')->insert([
                    'article_id' => $articleId,
                    'par_num' => 1,
                    'wordclass_id' => $wordclassId,
                    'group_num' => 1,
                    'type_id' => 1,
                    'word_order' => $wordOrder,
                    'lemma_id' => $lemma->id,
                ]);
                $wordOrder++;
            }
        }
    }
}
