<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Check types
echo "=== TYPES IN DATABASE ===\n";
$types = App\Models\Type::all();
foreach ($types as $type) {
    echo "ID: {$type->id}, Name: {$type->name}\n";
}

echo "\n=== SAMPLE ARTICLE STRUCTURE ===\n";
// Get first article with word relations
$article = App\Models\Article::with(['wordRelations.lemma', 'wordRelations.type'])
    ->whereHas('wordRelations')
    ->first();

if ($article) {
    echo "Article ID: {$article->id}\n";
    echo "Article Title: {$article->title}\n";
    echo "Word Relations count: {$article->wordRelations->count()}\n\n";
    
    echo "Words in this article:\n";
    foreach ($article->wordRelations->take(10) as $wr) {
        $typeName = $wr->type ? $wr->type->name : 'NULL';
        $lemmaName = $wr->lemma ? $wr->lemma->name : 'NULL';
        echo "  - {$lemmaName} (type: {$typeName}, type_id: {$wr->type_id})\n";
    }
}

echo "\n=== SEARCH EXAMPLE: 'makan' ===\n";
// Search for articles containing "makan"
$articlesWithKeyword = App\Models\Article::whereHas('wordRelations.lemma', function($q) {
    $q->where('name', 'LIKE', '%makan%');
})->with(['wordRelations.lemma', 'wordRelations.type', 'category', 'subcategory'])->take(5)->get();

echo "Found {$articlesWithKeyword->count()} articles containing 'makan'\n\n";

foreach ($articlesWithKeyword as $article) {
    echo "ARTICLE: {$article->title}\n";
    
    // Get article title lemma (type_id = 2)
    $titleLemma = $article->wordRelations->where('type_id', 2)->first();
    if ($titleLemma && $titleLemma->lemma) {
        echo "  Title lemma: {$titleLemma->lemma->name}\n";
    }
    
    // Get superordinate lemmas (type_id = 3)
    $superordinates = $article->wordRelations->where('type_id', 3);
    if ($superordinates->count() > 0) {
        echo "  Superordinates: " . $superordinates->pluck('lemma.name')->filter()->implode(', ') . "\n";
    }
    
    // Get ordinary lemmas (type_id = 1)
    $ordinaryLemmas = $article->wordRelations->where('type_id', 1);
    echo "  Ordinary lemmas (" . $ordinaryLemmas->count() . "): " . 
         $ordinaryLemmas->pluck('lemma.name')->filter()->take(10)->implode(', ') . 
         ($ordinaryLemmas->count() > 10 ? '...' : '') . "\n";
    
    echo "\n";
}
