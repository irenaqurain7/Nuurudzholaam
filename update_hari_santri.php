<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Hari Santri Nasional')->update([
    'deskripsi' => 'Peringatan Hari Santri Nasional di sekolah Nuurudzholam dilaksanakan sebagai bentuk penghormatan terhadap perjuangan para ulama dan santri dalam menjaga nilai-nilai keislaman serta kebangsaan. Kegiatan meliputi upacara hari santri, pembacaan sholawat, tausiyah, serta kegiatan keagamaan yang melibatkan seluruh siswa dan guru. Melalui peringatan ini, diharapkan siswa dapat meneladani akhlak santri, memperkuat nilai keislaman, dan menumbuhkan semangat cinta tanah air.'
]);

echo "Updated successfully\n";
