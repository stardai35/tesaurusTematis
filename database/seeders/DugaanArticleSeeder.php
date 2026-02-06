<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Type;
use App\Models\WordRelation;
use Illuminate\Database\Seeder;

class DugaanArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create/Get Word Classes
        $wordClassNomina = WordClass::firstOrCreate(['name' => 'nomina']);
        $wordClassVerba = WordClass::firstOrCreate(['name' => 'verba']);
        
        // Create/Get Type
        $typeAliases = Type::firstOrCreate(['name' => 'sinonimi']);
        
        // Create/Get Category
        $category = Category::firstOrCreate(
            ['title' => 'Makna Dasar'],
            ['slug' => 'makna-dasar']
        );
        
        // Create/Get Subcategory
        $subcategory = Subcategory::firstOrCreate(
            ['cat_id' => $category->id, 'title' => 'Anggapan dan Taksiran'],
            ['slug' => 'anggapan-dan-taksiran']
        );

        // Create Article DUGAAN
        $article = Article::firstOrCreate(
            ['title' => 'DUGAAN'],
            [
                'cat_id' => $category->id,
                'subcat_id' => $subcategory->id,
                'description' => 'Artikel DUGAAN mengandung sinonim dan makna terkait dengan anggapan, taksiran, dan pendapat sementara.',
                'num_lemma' => 0,
                'year_created' => 2024
            ]
        );

        // ============ NOMINA ============
        // Paragraf 1 - Makna 1
        $lemmaData = [
            'dugaan' => ['is_bold' => false, 'is_superordinate' => false],
            'asumsi' => ['is_bold' => false, 'is_superordinate' => false],
            'prasangka' => ['is_bold' => false, 'is_superordinate' => false],
            'anggapan' => ['is_bold' => false, 'is_superordinate' => false],
            'persangkaan' => ['is_bold' => false, 'is_superordinate' => false],
            'taksiran' => ['is_bold' => false, 'is_superordinate' => false],
        ];

        $wordOrder = 1;
        foreach ($lemmaData as $lemmaName => $attributes) {
            $lemma = Lemma::firstOrCreate(['name' => $lemmaName]);
            
            // Check if relation already exists
            $existingRelation = WordRelation::where('article_id', $article->id)
                ->where('lemma_id', $lemma->id)
                ->where('wordclass_id', $wordClassNomina->id)
                ->where('par_num', 1)
                ->first();
            
            if (!$existingRelation) {
                WordRelation::create([
                    'article_id' => $article->id,
                    'lemma_id' => $lemma->id,
                    'wordclass_id' => $wordClassNomina->id,
                    'par_num' => 1,
                    'meaning_group' => 1,
                    'type_id' => $typeAliases->id,
                    'word_order' => $wordOrder,
                    'description' => 'Bentuk nomina dari "dugaan"; taksiran atau pendapat yang belum pasti',
                    'is_bold' => $attributes['is_bold'],
                    'is_superordinate' => $attributes['is_superordinate'],
                    'group_num' => 1,
                ]);
            }
            $wordOrder++;
        }

        // Paragraf 2 - Makna 2 (nuansa berbeda)
        $lemmaData2 = [
            'menganut' => ['is_bold' => false, 'is_superordinate' => false],
            'berpikir' => ['is_bold' => false, 'is_superordinate' => false],
            'berkhayalan' => ['is_bold' => false, 'is_superordinate' => false],
            'maklum' => ['is_bold' => false, 'is_superordinate' => false],
            'tahu' => ['is_bold' => false, 'is_superordinate' => false],
            'paham' => ['is_bold' => false, 'is_superordinate' => false],
        ];

        $wordOrder = 1;
        foreach ($lemmaData2 as $lemmaName => $attributes) {
            $lemma = Lemma::firstOrCreate(['name' => $lemmaName]);
            
            // Check if relation already exists
            $existingRelation = WordRelation::where('article_id', $article->id)
                ->where('lemma_id', $lemma->id)
                ->where('wordclass_id', $wordClassNomina->id)
                ->where('par_num', 2)
                ->first();
            
            if (!$existingRelation) {
                WordRelation::create([
                    'article_id' => $article->id,
                    'lemma_id' => $lemma->id,
                    'wordclass_id' => $wordClassNomina->id,
                    'par_num' => 2,
                    'meaning_group' => 1,
                    'type_id' => $typeAliases->id,
                    'word_order' => $wordOrder,
                    'description' => 'Bentuk verba; melakukan anggapan atau mempertanyakan sesuatu',
                    'is_bold' => $attributes['is_bold'],
                    'is_superordinate' => $attributes['is_superordinate'],
                    'group_num' => 1,
                ]);
            }
            $wordOrder++;
        }

        // ============ VERBA ============
        // Paragraf 1 - Makna 1
        $lemmaDataVerba = [
            'menduga' => ['is_bold' => false, 'is_superordinate' => false],
            'menyangka' => ['is_bold' => false, 'is_superordinate' => false],
            'mengira' => ['is_bold' => false, 'is_superordinate' => false],
            'memperkirakan' => ['is_bold' => false, 'is_superordinate' => false],
            'memprakirakan' => ['is_bold' => false, 'is_superordinate' => false],
        ];

        $wordOrder = 1;
        foreach ($lemmaDataVerba as $lemmaName => $attributes) {
            $lemma = Lemma::firstOrCreate(['name' => $lemmaName]);
            
            // Check if relation already exists
            $existingRelation = WordRelation::where('article_id', $article->id)
                ->where('lemma_id', $lemma->id)
                ->where('wordclass_id', $wordClassVerba->id)
                ->where('par_num', 1)
                ->first();
            
            if (!$existingRelation) {
                WordRelation::create([
                    'article_id' => $article->id,
                    'lemma_id' => $lemma->id,
                    'wordclass_id' => $wordClassVerba->id,
                    'par_num' => 1,
                    'meaning_group' => 1,
                    'type_id' => $typeAliases->id,
                    'word_order' => $wordOrder,
                    'description' => 'Melakukan tindakan menduga atau mengira sesuatu; membuat perkiraan sementara',
                    'is_bold' => $attributes['is_bold'],
                    'is_superordinate' => $attributes['is_superordinate'],
                    'group_num' => 1,
                ]);
            }
            $wordOrder++;
        }

        // Update article num_lemma
        $article->update([
            'num_lemma' => $article->wordRelations()->count()
        ]);

        echo "✓ DugaanArticleSeeder completed. Created article DUGAAN with " . $article->wordRelations()->count() . " lemmas.\n";
    }
}
