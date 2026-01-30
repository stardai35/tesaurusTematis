<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test with lemma "makan"
$request = Illuminate\Http\Request::create('/lema/makan', 'GET');

$response = $kernel->handle($request);

if ($response->getStatusCode() === 200) {
    echo "✅ SUCCESS! Halaman lemma berhasil dimuat\n";
    echo "Status: " . $response->getStatusCode() . "\n";
    
    // Check if content has expected data
    $content = $response->getContent();
    if (str_contains($content, 'lemma-header')) {
        echo "✅ Struktur HTML ditemukan\n";
    }
    if (str_contains($content, 'makan')) {
        echo "✅ Nama lemma ditemukan\n";
    }
} else {
    echo "❌ ERROR! Status: " . $response->getStatusCode() . "\n";
    echo $response->getContent() . "\n";
}

$kernel->terminate($request, $response);
