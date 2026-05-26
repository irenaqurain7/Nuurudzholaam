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
                'deskripsi' => 'Pentas Seni Perpisahan Sekolah merupakan kegiatan tahunan yang diselenggarakan sebagai bentuk perayaan sekaligus momen kebersamaan seluruh keluarga besar Nuurudzholam. Acara ini menampilkan berbagai kreativitas siswa seperti tari, musik, drama, pembacaan puisi, dan penampilan seni lainnya. Selain menjadi wadah untuk menyalurkan bakat, kegiatan ini juga menjadi momen perpisahan yang penuh kesan bagi siswa kelas akhir sebelum melanjutkan ke jenjang pendidikan berikutnya.',
            ]);
    }
}
