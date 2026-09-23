<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rawText = 'Lie down on the floor and secure your feet.';
$url = 'https://api.mymemory.translated.net/get?q=' . urlencode($rawText) . '&langpair=en|id&de=admin@praxisfit.com';
$response = Illuminate\Support\Facades\Http::withoutVerifying()
    ->withHeaders([
        'User-Agent' => 'PraxisFit App / 1.0 (admin@praxisfit.com)'
    ])
    ->timeout(10)
    ->get($url);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
