<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test lemma makan
$lemma = App\Models\Lemma::where('name', 'makan')->first();

if (!$lemma) {
    echo "Lemma 'makan' tidak ditemukan!\n";
    exit(1);
}

echo "=== DEBUG LEMMA: {$lemma->name} ===\n\n";
echo "ID: {$lemma->id}\n";
echo "Label: " . ($lemma->label ? $lemma->label->name : 'NULL') . "\n";
echo "WordRelations count: " . $lemma->wordRelations->count() . "\n\n";

// Get article IDs
$articleIds = $lemma->wordRelations->pluck('article_id')->unique()->filter();
echo "Article IDs connected: " . $articleIds->implode(', ') . "\n";
echo "Total articles: " . $articleIds->count() . "\n\n";

if ($articleIds->isEmpty()) {
    echo "ERROR: Lemma 'makan' tidak terhubung ke article manapun!\n";
    echo "WordRelations:\n";
    foreach ($lemma->wordRelations as $wr) {
        echo "  - ID: {$wr->id}, article_id: " . ($wr->article_id ?? 'NULL') . ", type_id: " . ($wr->type_id ?? 'NULL') . "\n";
    }
    exit(1);
}

// Get all related words from same articles
$allRelations = App\Models\WordRelation::with(['lemma', 'type'])
    ->whereIn('article_id', $articleIds)
    ->where('lemma_id', '!=', $lemma->id)
    ->get();

echo "Total relations from same articles: " . $allRelations->count() . "\n\n";

// Categorize by type
$synonyms = collect();
$antonyms = collect();
$examples = collect();
$others = collect();

foreach ($allRelations as $relation) {
    if (!$relation->lemma) {
        echo "WARNING: Relation ID {$relation->id} has NULL lemma\n";
        continue;
    }
    
    if ($relation->type) {
        $typeName = strtolower($relation->type->name);
        
        if (in_array($typeName, ['sinonim', 'synonym'])) {
            $synonyms->push($relation);
        } elseif (in_array($typeName, ['antonim', 'antonym'])) {
            $antonyms->push($relation);
        } elseif (in_array($typeName, ['contoh', 'example'])) {
            $examples->push($relation);
        } else {
            $others->push($relation);
        }
    } else {
        echo "WARNING: Relation ID {$relation->id} has NULL type\n";
        $others->push($relation);
    }
}

echo "=== RESULTS ===\n";
echo "Sinonim: " . $synonyms->unique('lemma_id')->count() . "\n";
if ($synonyms->count() > 0) {
    foreach ($synonyms->unique('lemma_id')->take(5) as $syn) {
        echo "  - " . $syn->lemma->name . " (type: " . ($syn->type ? $syn->type->name : 'NULL') . ")\n";
    }
}

echo "\nAntonim: " . $antonyms->unique('lemma_id')->count() . "\n";
if ($antonyms->count() > 0) {
    foreach ($antonyms->unique('lemma_id')->take(5) as $ant) {
        echo "  - " . $ant->lemma->name . " (type: " . ($ant->type ? $ant->type->name : 'NULL') . ")\n";
    }
}

echo "\nContoh: " . $examples->count() . "\n";
if ($examples->count() > 0) {
    foreach ($examples->take(5) as $ex) {
        echo "  - " . $ex->lemma->name . " (type: " . ($ex->type ? $ex->type->name : 'NULL') . ")\n";
    }
}

echo "\nOthers: " . $others->unique('lemma_id')->count() . "\n";
if ($others->count() > 0) {
    foreach ($others->unique('lemma_id')->take(10) as $oth) {
        echo "  - " . $oth->lemma->name . " (type: " . ($oth->type ? $oth->type->name : 'NULL') . ", type_id: " . ($oth->type_id ?? 'NULL') . ")\n";
    }
}

echo "\n=== CHECKING TYPES IN DATABASE ===\n";
$types = App\Models\Type::all();
echo "Total types: " . $types->count() . "\n";
foreach ($types as $type) {
    echo "  - ID: {$type->id}, Name: {$type->name}\n";
}

echo "\n=== ALL RELATIONS FOR THIS LEMMA ===\n";
foreach ($allRelations as $rel) {
    echo "Lemma: " . ($rel->lemma ? $rel->lemma->name : 'NULL') . 
         ", Type: " . ($rel->type ? $rel->type->name : 'NULL') . 
         ", TypeID: " . ($rel->type_id ?? 'NULL') . "\n";
}
