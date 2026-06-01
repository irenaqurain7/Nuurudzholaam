<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Memperingati Hari Kartini')->update([
    'deskripsi' => 'Peringatan Hari Kartini di Sekolah Nuurudzholaam dilaksanakan untuk mengenang perjuangan R.A. Kartini dalam memperjuangkan pendidikan dan peran perempuan di Indonesia. Kegiatan diisi dengan memakai pakaian adat, penampilan seni, lomba bertema budaya, serta edukasi mengenai nilai perjuangan Kartini. Melalui kegiatan ini, siswa diharapkan dapat menumbuhkan rasa percaya diri, menghargai keberagaman budaya, dan meneruskan semangat belajar dengan penuh semangat.'
]);

echo "Updated successfully\n";
