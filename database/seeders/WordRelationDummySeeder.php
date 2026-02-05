<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\LabelType;

class WordRelationDummySeeder extends Seeder
{
    /**
     * Run the seeder - Populate articles dengan dummy word relations
     */
    public function run(): void
    {
        // Get all articles that don't have any word relations yet
        $articlesWithoutRelations = Article::doesnthave('wordRelations')->limit(20)->get();

        // Get some sample lemmas, word classes, and label types
        $wordClasses = WordClass::all();
        $labelTypes = LabelType::all();

        foreach ($articlesWithoutRelations as $article) {
            // Get 3-8 random lemmas for this article
            $lemmaCount = rand(3, 8);
            $lemmas = Lemma::inRandomOrder()->limit($lemmaCount)->get();

            $wordOrderCounter = 1;

            foreach ($lemmas as $index => $lemma) {
                $isFirst = ($index === 0);
                $randomWordClass = $wordClasses->random();
                $randomLabelType = $labelTypes->random();

                DB::table('word_relation')->insert([
                    'article_id' => $article->id,
                    'lemma_id' => $lemma->id,
                    'wordclass_id' => $randomWordClass->id,
                    'type_id' => rand(1, 4), // Random type from 1-4
                    'relationship_type' => $randomLabelType->id,
                    'par_num' => 1,
                    'group_num' => 1,
                    'word_order' => $wordOrderCounter++,
                    'is_superordinate' => $isFirst ? 1 : 0, // First lemma is superordinate
                    'meaning_group' => rand(1, 3),
                    'description' => $isFirst ? null : "Contoh penggunaan dari {$article->title}",
                    'foreign_language' => null,
                    'language_variant' => null,
                    'is_bold' => $isFirst ? 1 : 0,
                ]);
            }

            $this->command->info("Added {$lemmaCount} word relations to article: {$article->title}");
        }

        $this->command->info('Word relation seeding completed!');
    }
}
