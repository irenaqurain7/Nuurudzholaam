<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Santunan Anak Yatim dan Piatu')->update([
    'deskripsi' => 'Program Santunan Anak Yatim dan Piatu merupakan kegiatan sosial yang rutin dilaksanakan oleh Sekolah Nuurudzholaam sebagai bentuk kepedulian terhadap sesama. Kegiatan ini melibatkan siswa, guru, dan pihak sekolah dalam berbagi bantuan serta doa bersama. Melalui kegiatan ini, sekolah menanamkan nilai empati, kebersamaan, dan rasa syukur kepada seluruh siswa agar tumbuh menjadi pribadi yang peduli terhadap lingkungan sekitar.'
]);

echo "Updated successfully\n";
