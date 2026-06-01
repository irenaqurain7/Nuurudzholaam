<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Activity;

Activity::where('judul', 'Maulid Nabi Muhammad')->update([
    'deskripsi' => 'Maulid Nabi Muhammad saw di Sekolah Nuurudzholaam menjadi momen untuk mengenang kelahiran Rasulullah saw sekaligus meneladani akhlak beliau dalam kehidupan sehari-hari. Kegiatan diisi dengan pembacaan sholawat, pengajian bersama, ceramah keagamaan, dan doa bersama yang diikuti oleh seluruh siswa serta guru. Melalui kegiatan ini, diharapkan siswa semakin mencintai Rasulullah saw dan menerapkan nilai-nilai Islam dalam keseharian.'
]);

echo "Updated successfully\n";
