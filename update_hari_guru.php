<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Memperingati Hari Guru')->update([
    'deskripsi' => 'Dalam rangka memperingati Hari Guru Nasional, sekolah Nuurudzholam mengadakan berbagai kegiatan sebagai bentuk penghormatan dan apresiasi kepada para guru yang telah mendidik dengan penuh dedikasi. Kegiatan diisi dengan penampilan dari siswa, pemberian ucapan dan hadiah sederhana, serta acara kebersamaan antara guru dan siswa. Peringatan ini menjadi momen untuk menumbuhkan rasa hormat, terima kasih, dan semangat belajar dalam lingkungan sekolah.'
]);

echo "Updated successfully\n";
