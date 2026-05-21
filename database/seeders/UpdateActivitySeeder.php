<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class UpdateActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::where('judul', 'Pentas Seni (Konser Musik dan Tari)')
            ->update([
                'judul' => 'Pentas Seni (Perpisahan Sekolah)',
                'deskripsi' => 'Pentas Seni Perpisahan Sekolah adalah acara spesial yang menampilkan performa seni siswa kelas akhir sebagai bentuk perayaan dan kenang-kenangan. Acara ini menampilkan musik, tari, drama, dan seni pertunjukan lainnya dari siswa yang akan lulus. Momen ini menjadi kesempatan emas bagi mereka untuk meninggalkan warisan seni yang indah dan berkesan bagi adik-adik kelas mereka.',
            ]);
    }
}
