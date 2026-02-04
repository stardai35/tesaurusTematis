<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Lemma;
use App\Models\Label;
use App\Models\WordClass;
use App\Models\WordRelation;

class TesaurusSampleDataSeeder extends Seeder
{
    /**
     * Seeder untuk membuat contoh data lengkap sesuai struktur Tesaurus
     * 
     * Contoh: Artikel CEPAT dengan sinonim, hiponim, dan ragam bahasa
     */
    public function run(): void
    {
        // 1. Buat kategori jika belum ada
        $categoryMovement = Category::firstOrCreate(
            ['title' => 'Gerak dan Gerakan'],
            [
                'num' => 1,
                'slug' => 'gerak-dan-gerakan'
            ]
        );

        // 2. Buat subkategori
        $subcatSpeed = Subcategory::firstOrCreate(
            [
                'cat_id' => $categoryMovement->id,
                'title' => 'Kecepatan Gerak'
            ],
            [
                'num' => 1,
                'slug' => 'kecepatan-gerak'
            ]
        );

        // 3. Buat artikel
        $article = Article::firstOrCreate(
            [
                'cat_id' => $categoryMovement->id,
                'subcat_id' => $subcatSpeed->id,
                'title' => 'CEPAT'
            ],
            [
                'num' => 1,
                'slug' => 'cepat'
            ]
        );

        // 4. Ambil atau buat lemmas (kata-kata)
        $lemmas = [];
        $lemmaNames = [
            'cepat',
            'kilat',
            'gesit',
            'segera',
            'lekas',
            'deras',
            'melesat',
            'terbang'
        ];

        $wordClass = WordClass::where('name', 'Adjektiva')->first() ?? 
                     WordClass::create(['name' => 'Adjektiva', 'abbr' => 'a']);

        foreach ($lemmaNames as $index => $name) {
            $lemma = Lemma::firstOrCreate(
                ['name' => $name],
                [
                    'label_id' => Label::where('name', 'adjektiva')->first()?->id ?? 1,
                    'name_tagged' => $name
                ]
            );
            $lemmas[$name] = $lemma->id;
        }

        // 5. Ambil relationship types
        $sinonimi = DB::table('label_type')->where('name', 'sinonimi')->first()?->id ?? 1;
        $hiponimi = DB::table('label_type')->where('name', 'hiponimi')->first()?->id ?? 1;

        // 6. Masukkan word relations sesuai struktur Tesaurus

        // Paragraf 1: Sinonim utama
        $wordRelations = [
            // Superordinat "GERAK CEPAT"
            [
                'article_id' => $article->id,
                'lemma_id' => null,
                'par_num' => 1,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 0,
                'is_superordinate' => true,
                'is_bold' => false,
                'description' => 'GERAK CEPAT',
                'foreign_language' => null,
                'language_variant' => null,
            ],
            // Sinonim grup 1: cepat, kilat, gesit, segera
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['cepat'],
                'par_num' => 1,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 1,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['kilat'],
                'par_num' => 1,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 2,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['gesit'],
                'par_num' => 1,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 3,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['segera'],
                'par_num' => 1,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 4,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            // Sinonim grup 2 (nuansa berbeda): lekas, deras
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['lekas'],
                'par_num' => 1,
                'meaning_group' => 2,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 5,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['deras'],
                'par_num' => 1,
                'meaning_group' => 2,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 6,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            // Sinonim grup 3: melesat, terbang
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['melesat'],
                'par_num' => 1,
                'meaning_group' => 3,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 7,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => null,
            ],
            [
                'article_id' => $article->id,
                'lemma_id' => $lemmas['terbang'],
                'par_num' => 1,
                'meaning_group' => 3,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'relationship_type' => $sinonimi,
                'word_order' => 8,
                'is_superordinate' => false,
                'is_bold' => false,
                'description' => null,
                'foreign_language' => null,
                'language_variant' => 'cak',  // ragam cakapan
            ],
        ];

        // Insert semua word relations
        foreach ($wordRelations as $relation) {
            WordRelation::updateOrCreate(
                [
                    'article_id' => $relation['article_id'],
                    'lemma_id' => $relation['lemma_id'],
                    'par_num' => $relation['par_num'],
                    'word_order' => $relation['word_order'],
                ],
                $relation
            );
        }

        $this->command->info('Sample Tesaurus data seeded successfully!');
        $this->command->info('Artikel: CEPAT dengan ' . count($wordRelations) . ' word relations');
    }
}
