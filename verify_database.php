<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== STATISTIK DATABASE TESAURUS ===\n\n";

echo "Jumlah Lemma: " . DB::table('lemma')->count() . "\n";
echo "Jumlah Article: " . DB::table('article')->count() . "\n";
echo "Jumlah Word Relation: " . DB::table('word_relation')->count() . "\n";
echo "Jumlah Category: " . DB::table('category')->count() . "\n";
echo "Jumlah Subcategory: " . DB::table('subcategory')->count() . "\n";
echo "Jumlah Word Class: " . DB::table('word_class')->count() . "\n";
echo "Jumlah Type: " . DB::table('type')->count() . "\n";
echo "Jumlah Label: " . DB::table('label')->count() . "\n\n";

echo "=== DAFTAR ARTIKEL ===\n\n";
$articles = DB::table('article')
    ->join('category', 'article.cat_id', '=', 'category.id')
    ->select('article.id', 'article.title', 'category.title as cat_title')
    ->orderBy('article.id')
    ->get();

foreach ($articles as $article) {
    $wordCount = DB::table('word_relation')->where('article_id', $article->id)->count();
    echo "{$article->id}. {$article->title} (Kategori: {$article->cat_title}) - {$wordCount} kata\n";
}

echo "\n=== CONTOH ISI ARTIKEL 'Angka dan Bilangan' ===\n\n";
$relations = DB::table('word_relation')
    ->join('lemma', 'word_relation.lemma_id', '=', 'lemma.id')
    ->where('article_id', 1)
    ->select('lemma.name', 'word_relation.word_order')
    ->orderBy('word_relation.word_order')
    ->get();

foreach ($relations as $rel) {
    echo "{$rel->word_order}. {$rel->name}\n";
}

echo "\n=== CONTOH PENCARIAN KATA 'makan' ===\n\n";
$lemma = DB::table('lemma')->where('name', 'makan')->first();
if ($lemma) {
    echo "Ditemukan: {$lemma->name}\n";
    echo "Label ID: " . ($lemma->label_id ?? 'NULL') . "\n";
    
    $articles = DB::table('word_relation')
        ->join('article', 'word_relation.article_id', '=', 'article.id')
        ->where('word_relation.lemma_id', $lemma->id)
        ->select('article.title')
        ->get();
    
    if ($articles->count() > 0) {
        echo "Muncul di artikel:\n";
        foreach ($articles as $art) {
            echo "  - {$art->title}\n";
        }
    }
}

echo "\n=== SELESAI ===\n";
