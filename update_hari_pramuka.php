<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Memperingati Hari Pramuka')->update([
    'deskripsi' => 'Dalam rangka memperingati Hari Pramuka, Sekolah Nuurudzholaam mengadakan berbagai kegiatan yang bertujuan menanamkan kedisiplinan, tanggung jawab, dan semangat kebersamaan kepada siswa. Kegiatan meliputi upacara, latihan baris-berbaris, demonstrasi keterampilan kepramukaan, serta permainan edukatif yang membangun kerja sama. Kegiatan ini menjadi sarana untuk membentuk karakter siswa yang mandiri dan berjiwa kepemimpinan.'
]);

echo "Updated successfully\n";
