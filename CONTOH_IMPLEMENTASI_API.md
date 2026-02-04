# API dan Kode Contoh - Tesaurus Tematis

## 1. Menampilkan Lemma dengan Paragraf

### Controller Method

```php
use App\Helpers\TesaurusFormatter;

public function lemma($slug)
{
    // Parse slug ke nama lemma
    $name = str_replace('-', ' ', $slug);
    
    // Load lemma dengan relasi lengkap
    $lemma = Lemma::with([
        'label',
        'wordRelations' => function($q) {
            $q->with([
                'wordClass',
                'article',
                'relationshipType'
            ])
            ->orderBy('article_id', 'asc')
            ->orderBy('par_num', 'asc')
            ->orderBy('meaning_group', 'asc')
            ->orderBy('word_order', 'asc');
        }
    ])
    ->where('name', $name)
    ->firstOrFail();

    $formatter = new TesaurusFormatter();
    $relations = $lemma->wordRelations;

    return view('lemma', compact('lemma', 'relations', 'formatter'));
}
```

### Blade View

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <x-lemma-display :lemma="$lemma" :relations="$relations" :formatter="$formatter" />
    
    <!-- Bagian Sinonim -->
    @if($relations->where('relationshipType.name', 'sinonimi')->count() > 0)
    <section class="mt-8">
        <h3>Sinonim</h3>
        <x-article-paragraph 
            :wordRelations="$relations->where('relationshipType.name', 'sinonimi')" 
            :formatter="$formatter" 
        />
    </section>
    @endif
</div>
@endsection
```

## 2. Membuat Artikel Baru dengan Paragraf

### Contoh Input Data

```php
use App\Models\Article;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\WordClass;
use App\Models\WordRelation;

// Langkah 1: Buat artikel
$article = Article::create([
    'cat_id' => 1,
    'subcat_id' => 1,
    'num' => 1,
    'title' => 'BIRU',
    'slug' => 'biru',
]);

// Langkah 2: Buat lemma jika belum ada
$lemmas = [];
$colors = ['biru', 'biru-langit', 'biru-tua', 'kobalt'];

foreach ($colors as $color) {
    $lemma = Lemma::firstOrCreate(
        ['name' => $color],
        ['label_id' => 1] // adjektiva
    );
    $lemmas[$color] = $lemma->id;
}

// Langkah 3: Masukkan word relations dengan struktur paragraf
$relations = [
    // Superordinat
    [
        'article_id' => $article->id,
        'lemma_id' => null, // Superordinat tidak punya lemma
        'par_num' => 1,
        'meaning_group' => 1,
        'wordclass_id' => 1,
        'type_id' => 1,
        'is_superordinate' => true,
        'description' => 'WARNA BIRU',
        'word_order' => 0,
    ],
    // Sinonim 1: Biru
    [
        'article_id' => $article->id,
        'lemma_id' => $lemmas['biru'],
        'par_num' => 1,
        'meaning_group' => 1,
        'wordclass_id' => 1,
        'type_id' => 1,
        'relationship_type' => 1, // sinonimi
        'word_order' => 1,
    ],
    // Sinonim 2: Biru-langit
    [
        'article_id' => $article->id,
        'lemma_id' => $lemmas['biru-langit'],
        'par_num' => 1,
        'meaning_group' => 1,
        'wordclass_id' => 1,
        'type_id' => 1,
        'relationship_type' => 1,
        'word_order' => 2,
    ],
    // Sinonim 3 (nuansa berbeda): Biru-tua
    [
        'article_id' => $article->id,
        'lemma_id' => $lemmas['biru-tua'],
        'par_num' => 1,
        'meaning_group' => 2,
        'wordclass_id' => 1,
        'type_id' => 1,
        'relationship_type' => 1,
        'word_order' => 3,
    ],
    // Sinonim 4: Kobalt
    [
        'article_id' => $article->id,
        'lemma_id' => $lemmas['kobalt'],
        'par_num' => 1,
        'meaning_group' => 2,
        'wordclass_id' => 1,
        'type_id' => 1,
        'relationship_type' => 1,
        'word_order' => 4,
        'foreign_language' => 'English: cobalt',
    ],
];

// Insert semua relations
foreach ($relations as $relation) {
    WordRelation::create($relation);
}
```

## 3. Mengubah Urutan Kata dengan Smart Sort

```php
use App\Helpers\TesaurusFormatter;

// Contoh 1: Urutan abjad normal
$words = ['zebra', 'apel', 'mango', 'banana'];
$sorted = TesaurusFormatter::smartSort($words);
// Hasil: ['apel', 'banana', 'mango', 'zebra']

// Contoh 2: Urutan bulan (otomatis terdeteksi)
$months = ['Desember', 'Januari', 'Mei', 'Maret'];
$sorted = TesaurusFormatter::smartSort($months);
// Hasil: ['Januari', 'Maret', 'Mei', 'Desember']

// Contoh 3: Urutan hari
$days = ['Sabtu', 'Minggu', 'Senin', 'Jumat'];
$sorted = TesaurusFormatter::smartSort($days);
// Hasil: ['Minggu', 'Senin', 'Jumat', 'Sabtu']

// Contoh 4: Urutan pangkat militer
$ranks = ['Kolonel', 'Sersan', 'Mayor', 'Letnan'];
$sorted = TesaurusFormatter::smartSort($ranks);
// Hasil: ['Sersan', 'Mayor', 'Letnan', 'Kolonel']
```

## 4. Menampilkan Ragam Bahasa

```blade
<!-- Lemma dengan ragam cakapan -->
<x-word-item 
    :word="$wordRelation" 
    :language-variant="$wordRelation->language_variant"
/>

<!-- Hasil: kata (ragam cakapan) -->
```

### Dalam Component

```php
// resources/views/components/word-item.blade.php
@props(['word', 'languageVariant'])

<span class="word-item">
    {{ $word->lemma->name }}
    
    @if($languageVariant)
        <span class="language-variant">
            @php
                $labels = [
                    'cak' => 'ragam cakapan',
                    'kas' => 'ragam kasar',
                    'hor' => 'ragam hormat',
                ];
            @endphp
            ({{ $labels[$languageVariant] ?? $languageVariant }})
        </span>
    @endif
</span>
```

## 5. Query Lanjutan

### Mendapatkan Semua Sinonim Lemma

```php
$lemma = Lemma::find($id);

$synonyms = $lemma->wordRelations()
    ->with(['article', 'relationshipType'])
    ->where('relationship_type', function($q) {
        $q->where('label_type.name', 'sinonimi');
    })
    ->get();
```

### Mendapatkan Artikel dengan Kategori

```php
$article = Article::with([
    'category',
    'subcategory',
    'wordRelations' => function($q) {
        $q->with(['lemma', 'relationshipType'])
          ->orderBy('par_num')
          ->orderBy('meaning_group')
          ->orderBy('word_order');
    }
])
->where('slug', 'cepat')
->first();
```

### Mencari Lemma yang Memiliki Ragam Bahasa Spesifik

```php
// Cari semua kata dengan ragam cakapan
$cakapanWords = WordRelation::where('language_variant', 'cak')
    ->with(['lemma', 'article'])
    ->get();

// Cari kata asing
$foreignWords = WordRelation::whereNotNull('foreign_language')
    ->with(['lemma', 'article'])
    ->get();
```

### Mendapatkan Statistik Artikel

```php
$stats = Article::with(['wordRelations'])
    ->get()
    ->map(function($article) {
        return [
            'title' => $article->title,
            'total_words' => $article->wordRelations->count(),
            'paragraphs' => $article->wordRelations->max('par_num'),
            'synonyms' => $article->wordRelations->where('relationshipType.name', 'sinonimi')->count(),
        ];
    });
```

## 6. Menampilkan Pencarian dengan Highlighting

```php
// Controller
public function search(Request $request)
{
    $query = $request->input('q');
    
    $results = Lemma::where('name', 'LIKE', "%{$query}%")
        ->with([
            'wordRelations' => function($q) {
                $q->with(['article', 'relationshipType'])
                  ->orderBy('par_num');
            },
            'label'
        ])
        ->paginate(15);

    return view('search-results', [
        'results' => $results,
        'query' => $query,
        'formatter' => new TesaurusFormatter()
    ]);
}

// Blade
@foreach($results as $lemma)
<div class="search-result">
    <h3>{{ $lemma->name }}</h3>
    
    @if($lemma->wordRelations->count() > 0)
    <p class="result-preview">
        Ditemukan dalam {{ $lemma->wordRelations->count() }} artikel:
        @foreach($lemma->wordRelations->take(3) as $rel)
            <span class="article-tag">{{ $rel->article->title }}</span>
        @endforeach
    </p>
    @endif
    
    <a href="{{ route('lemma', $lemma->slug) }}" class="read-more">Lihat detail →</a>
</div>
@endforeach
```

## 7. Batch Import Data dari CSV

```php
// Buat job untuk import
php artisan make:job ImportTesaurusData

// Job class
public function handle()
{
    $file = storage_path('imports/tesaurus_data.csv');
    
    $rows = array_map('str_getcsv', file($file));
    
    foreach ($rows as $row) {
        [$lemmaName, $articleTitle, $paragraph, $meaningGroup, $type, $order] = $row;
        
        $lemma = Lemma::firstOrCreate(['name' => $lemmaName]);
        $article = Article::firstOrCreate(['title' => $articleTitle]);
        
        WordRelation::create([
            'lemma_id' => $lemma->id,
            'article_id' => $article->id,
            'par_num' => $paragraph,
            'meaning_group' => $meaningGroup,
            'relationship_type' => Type::where('name', $type)->first()?->id,
            'word_order' => $order,
        ]);
    }
}
```

## 8. Cache untuk Performance

```php
// Cache hasil pencarian
public function search(Request $request)
{
    $query = $request->input('q');
    $cacheKey = "search_" . md5($query);
    
    $results = Cache::remember($cacheKey, 3600, function() use ($query) {
        return Lemma::where('name', 'LIKE', "%{$query}%")
            ->with(['wordRelations.article', 'label'])
            ->get();
    });
    
    return view('search-results', compact('results', 'query'));
}

// Cache home page stats
public function index()
{
    $stats = Cache::remember('tesaurus_stats', 86400, function() {
        return [
            'total_words' => Lemma::count(),
            'total_articles' => Article::count(),
            'total_relations' => WordRelation::count(),
        ];
    });
    
    return view('home', compact('stats'));
}
```

## 9. Testing WordRelation Creation

```php
// tests/Unit/WordRelationTest.php

public function test_create_superordinate()
{
    $article = Article::factory()->create();
    
    $superordinate = WordRelation::create([
        'article_id' => $article->id,
        'par_num' => 1,
        'is_superordinate' => true,
        'description' => 'WARNA',
        'word_order' => 0,
    ]);
    
    $this->assertTrue($superordinate->is_superordinate);
    $this->assertNull($superordinate->lemma_id);
}

public function test_create_synonym_relation()
{
    $article = Article::factory()->create();
    $lemma = Lemma::factory()->create();
    $sinonimi = LabelType::where('name', 'sinonimi')->first();
    
    $relation = WordRelation::create([
        'article_id' => $article->id,
        'lemma_id' => $lemma->id,
        'par_num' => 1,
        'meaning_group' => 1,
        'relationship_type' => $sinonimi->id,
        'word_order' => 1,
    ]);
    
    $this->assertEquals('sinonimi', $relation->relationshipType->name);
}
```

---

Gunakan contoh-contoh ini sebagai referensi saat mengembangkan fitur baru atau menambah data ke Tesaurus.
