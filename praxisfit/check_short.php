<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$short = App\Models\Exercise::whereRaw('LENGTH(instructions) < 130')->get(['name', 'instructions']);
foreach($short as $s) {
    echo $s->name . ': ' . $s->instructions . "\n---\n";
}
