<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Lemma;
use App\Models\WordRelation;
use App\Models\WordClass;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TesaurusFormattingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed label_type data
        $this->artisan('db:seed', ['--class' => 'LabelTypeSeeder']);
    }

    /**
     * Test pembuatan artikel dengan paragraf dan word relations
     */
    public function test_create_article_with_paragraphs()
    {
        // Arrange
        $category = Category::create(['title' => 'Test', 'slug' => 'test', 'num' => 1]);
        $subcategory = Subcategory::create([
            'cat_id' => $category->id,
            'title' => 'Test Sub',
            'slug' => 'test-sub',
            'num' => 1
        ]);
        
        $article = Article::create([
            'cat_id' => $category->id,
            'subcat_id' => $subcategory->id,
            'title' => 'CEPAT',
            'slug' => 'cepat',
            'num' => 1,
        ]);

        // Act & Assert
        $this->assertDatabaseHas('article', [
            'title' => 'CEPAT',
            'cat_id' => $category->id,
        ]);
    }

    /**
     * Test pembuatan superordinat (kata tanpa lemma_id)
     */
    public function test_create_superordinate_word_relation()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act
        $relation = WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => null, // Superordinat tidak punya lemma
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'is_superordinate' => true,
            'description' => 'WARNA',
            'word_order' => 0,
        ]);

        // Assert
        $this->assertTrue($relation->is_superordinate);
        $this->assertNull($relation->lemma_id);
        $this->assertEquals('WARNA', $relation->description);
    }

    /**
     * Test pembuatan relasi sinonimi
     */
    public function test_create_synonym_relation()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemma = Lemma::create(['name' => 'cepat', 'label_id' => 1]);
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);
        $sinonimi = \DB::table('label_type')->where('name', 'sinonimi')->first();

        // Act
        $relation = WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => $lemma->id,
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'relationship_type' => $sinonimi->id,
            'word_order' => 1,
        ]);

        // Assert
        $this->assertNotNull($relation->lemma_id);
        $this->assertFalse($relation->is_superordinate);
        $this->assertEquals('sinonimi', $relation->relationshipType->name);
    }

    /**
     * Test pembuatan kata dengan ragam bahasa
     */
    public function test_create_word_with_language_variant()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemma = Lemma::create(['name' => 'cepat', 'label_id' => 1]);
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act
        $relation = WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => $lemma->id,
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'language_variant' => 'cak', // ragam cakapan
            'word_order' => 1,
        ]);

        // Assert
        $this->assertEquals('cak', $relation->language_variant);
        $this->assertDatabaseHas('word_relation', [
            'lemma_id' => $lemma->id,
            'language_variant' => 'cak',
        ]);
    }

    /**
     * Test pembuatan kata asing (foreign language)
     */
    public function test_create_word_with_foreign_language()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemma = Lemma::create(['name' => 'cepat', 'label_id' => 1]);
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act
        $relation = WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => $lemma->id,
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'foreign_language' => 'English: quick',
            'word_order' => 1,
        ]);

        // Assert
        $this->assertEquals('English: quick', $relation->foreign_language);
    }

    /**
     * Test pembuatan acuan ke artikel lain (is_bold)
     */
    public function test_create_bold_reference()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemma = Lemma::create(['name' => 'cepat', 'label_id' => 1]);
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act
        $relation = WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => $lemma->id,
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'is_bold' => true, // akan menjadi link ke artikel lain
            'word_order' => 1,
        ]);

        // Assert
        $this->assertTrue($relation->is_bold);
    }

    /**
     * Test paragraph grouping dengan meaning_group yang berbeda
     */
    public function test_paragraph_with_different_meaning_groups()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemmas = [
            'kata1' => Lemma::create(['name' => 'kata1', 'label_id' => 1])->id,
            'kata2' => Lemma::create(['name' => 'kata2', 'label_id' => 1])->id,
            'kata3' => Lemma::create(['name' => 'kata3', 'label_id' => 1])->id,
        ];
        
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act - buat 3 kata dengan meaning_group berbeda
        foreach ($lemmas as $key => $lemmaId) {
            $meaningGroup = $key === 'kata1' ? 1 : 2;
            WordRelation::create([
                'article_id' => $article->id,
                'lemma_id' => $lemmaId,
                'par_num' => 1,
                'meaning_group' => $meaningGroup,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'word_order' => array_search($key, ['kata1', 'kata2', 'kata3']) + 1,
            ]);
        }

        // Assert
        $relations = $article->wordRelations;
        $this->assertEquals(3, $relations->count());
        $this->assertEquals(1, $relations->where('meaning_group', 1)->count());
        $this->assertEquals(2, $relations->where('meaning_group', 2)->count());
    }

    /**
     * Test query word relations dengan relasi yang benar
     */
    public function test_query_word_relations_with_eager_loading()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemma = Lemma::create(['name' => 'cepat', 'label_id' => 1]);
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);
        $sinonimi = \DB::table('label_type')->where('name', 'sinonimi')->first();

        WordRelation::create([
            'article_id' => $article->id,
            'lemma_id' => $lemma->id,
            'par_num' => 1,
            'meaning_group' => 1,
            'wordclass_id' => $wordClass->id,
            'type_id' => 1,
            'relationship_type' => $sinonimi->id,
            'word_order' => 1,
        ]);

        // Act
        $relation = WordRelation::with(['lemma', 'article', 'relationshipType'])->first();

        // Assert
        $this->assertNotNull($relation->lemma);
        $this->assertNotNull($relation->article);
        $this->assertNotNull($relation->relationshipType);
        $this->assertEquals('cepat', $relation->lemma->name);
        $this->assertEquals('sinonimi', $relation->relationshipType->name);
    }

    /**
     * Test pengelompokan paragraf dalam artikel
     */
    public function test_group_word_relations_by_paragraph()
    {
        // Arrange
        $article = Article::create([
            'cat_id' => 1,
            'title' => 'TEST',
            'slug' => 'test',
            'num' => 1,
        ]);
        
        $lemmas = [
            Lemma::create(['name' => 'kata1', 'label_id' => 1])->id,
            Lemma::create(['name' => 'kata2', 'label_id' => 1])->id,
            Lemma::create(['name' => 'kata3', 'label_id' => 1])->id,
        ];
        
        $wordClass = WordClass::firstOrCreate(['name' => 'Adjektiva', 'abbr' => 'a']);

        // Act - buat relations di 2 paragraf berbeda
        foreach ($lemmas as $index => $lemmaId) {
            $parNum = $index < 2 ? 1 : 2;
            WordRelation::create([
                'article_id' => $article->id,
                'lemma_id' => $lemmaId,
                'par_num' => $parNum,
                'meaning_group' => 1,
                'wordclass_id' => $wordClass->id,
                'type_id' => 1,
                'word_order' => $index + 1,
            ]);
        }

        // Assert
        $relations = WordRelation::where('article_id', $article->id)->get();
        $groupedByPar = $relations->groupBy('par_num');
        
        $this->assertEquals(2, $groupedByPar->count());
        $this->assertEquals(2, $groupedByPar[1]->count());
        $this->assertEquals(1, $groupedByPar[2]->count());
    }
}
