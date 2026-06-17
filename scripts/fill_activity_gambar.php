<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Activity;

$ext = ['jpeg','jpg','png','webp'];
$updated = 0;
foreach (Activity::whereNull('gambar')->orWhere('gambar', '')->get() as $a) {
    foreach ($ext as $e) {
        $p = public_path('images/kegiatan/' . $a->judul . '.' . $e);
        if (file_exists($p)) {
            $a->gambar = $a->judul . '.' . $e;
            $a->save();
            echo "Updated {$a->id} => {$a->gambar}\n";
            $updated++;
            break;
        }
    }
}

echo "Done. Updated: {$updated}\n";
