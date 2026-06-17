<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;

function normalize($s) {
    $s = strtolower($s);
    $s = preg_replace('/[^a-z0-9\s]/', ' ', $s);
    $parts = array_filter(array_map('trim', explode(' ', $s)), function($w){ return strlen($w) > 2; });
    return $parts;
}

$dir = public_path('images/kegiatan');
$files = array_values(array_filter(scandir($dir), function($f) use ($dir){ return is_file($dir . DIRECTORY_SEPARATOR . $f); }));

$updated = 0;
foreach (Activity::whereNull('gambar')->orWhere('gambar', '')->get() as $a) {
    $titleWords = normalize($a->judul);
    $best = null;
    $bestScore = 0;
    foreach ($files as $file) {
        $name = pathinfo($file, PATHINFO_FILENAME);
        $nameWords = normalize($name);
        $score = count(array_intersect($titleWords, $nameWords));
        if ($score > $bestScore) { $bestScore = $score; $best = $file; }
    }
    if ($bestScore >= 2 && $best) {
        $a->gambar = $best;
        $a->save();
        echo "Fuzzy matched {$a->id} => {$best} (score {$bestScore})\n";
        $updated++;
    } else {
        echo "No good match for {$a->id} ({$a->judul})\n";
    }
}

echo "Fuzzy done. Updated: {$updated}\n";
