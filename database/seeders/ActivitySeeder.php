<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'judul' => 'Memperingati Hari Pramuka',
                'deskripsi' => 'Sekolah Nuurudzholaam merayakan Hari Pramuka dengan berbagai kegiatan seru meliputi upacara bendera, demonstrasi ketrampilan Pramuka, dan pemberian penghargaan kepada anggota Pramuka berprestasi. Kegiatan ini bertujuan untuk meningkatkan semangat nasionalisme dan kebersamaan di kalangan siswa.',
                'tanggal' => now()->setMonth(8)->setDay(14),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Memperingati Hari Kartini',
                'deskripsi' => 'Perayaan Hari Kartini di sekolah kami menampilkan berbagai kegiatan edukatif tentang perjuangan dan dedikasi Raden Ajeng Kartini. Siswa mengikuti seminar, lomba kebaya, dan diskusi tentang peran perempuan dalam pendidikan dan pembangunan masyarakat.',
                'tanggal' => now()->setMonth(4)->setDay(21),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Memperingati Hari Guru',
                'deskripsi' => 'Siswa-siswi Nuurudzholaam memberikan apresiasi kepada para pendidik melalui berbagai acara spesial termasuk pertunjukan seni, pemberian hadiah, dan upacara peringatan. Acara ini menjadi momentum untuk menghargai dedikasi dan pengorbanan guru-guru dalam mendidik generasi muda.',
                'tanggal' => now()->setMonth(11)->setDay(25),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Maulid Nabi Muhammad',
                'deskripsi' => 'Perayaan Maulid Nabi Muhammad adalah momentum spiritual bagi komunitas sekolah. Kegiatan meliputi pengajian, doa bersama, ceramah agama, dan sharing tentang akhlak dan sifat-sifat mulia Nabi Muhammad SAW. Siswa mendapatkan pengetahuan mendalam tentang sejarah dan kehidupan Rasulullah.',
                'tanggal' => now()->setMonth(9)->setDay(16),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Santunan Anak Yatim dan Piatu',
                'deskripsi' => 'Program sosial kemanusiaan Sekolah Nuurudzholaam yang secara rutin memberikan santunan kepada anak-anak yatim dan piatu. Program ini mengajarkan siswa tentang kepedulian sosial, berbagi rejeki, dan arti dari ketulusan dalam berbuat baik kepada sesama.',
                'tanggal' => now()->setMonth(6)->setDay(15),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Buka Bersama (Iftar Bersama)',
                'deskripsi' => 'Pada bulan Ramadan, sekolah mengadakan kegiatan buka puasa bersama sebagai simbol persatuan dan kebersamaan. Seluruh warga sekolah berkumpul untuk berbuka puasa dan melakukan pengajian sore. Kegiatan ini memperkuat ikatan silaturahmi di antara guru, siswa, dan orang tua.',
                'tanggal' => now()->setMonth(3)->setDay(20),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Pentas Seni (Konser Musik dan Tari)',
                'deskripsi' => 'Pentas seni adalah ajang apresiasi terhadap bakat dan kreativitas siswa di bidang musik, tari, dan seni pertunjukan lainnya. Acara tahunan ini menampilkan performa spektakuler dari berbagai kelompok seni sekolah dan menjadi kesempatan bagi siswa untuk menunjukkan kemampuan mereka di atas panggung.',
                'tanggal' => now()->setMonth(12)->setDay(10),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
            [
                'judul' => 'Hari Santri Nasional',
                'deskripsi' => 'Sebagai sekolah Islam, Nuurudzholaam secara khusus merayakan Hari Santri Nasional dengan berbagai kegiatan edukatif dan spiritual. Kegiatan mencakup ceramah inspiratif, pembacaan kitab kuning, dan diskusi tentang peran santri dalam membangun bangsa yang berakhlak mulia.',
                'tanggal' => now()->setMonth(10)->setDay(22),
                'kategori' => 'kegiatan',
                'visibility' => 'publik',
                'gambar' => null,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(
                ['judul' => $activity['judul']],
                $activity
            );
        }
    }
}
