<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // Kategori: Umum
            [
                'pertanyaan' => 'Apa itu Nuurudzholaam (Nuzo)?',
                'jawaban' => 'Nuurudzholaam (Nuzo) adalah lembaga pendidikan Islam terpadu yang menyelenggarakan program pendidikan mulai dari TK, SD, SMP, hingga SMK dengan memadukan kurikulum nasional dan nilai-nilai kepesantrenan.',
                'kategori' => 'umum',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Di mana lokasi sekolah Nuurudzholaam?',
                'jawaban' => 'Sekolah Nuurudzholaam berlokasi di Jl. Masjid Nurul Dhalam, Karawang, Jawa Barat. Anda dapat melihat peta lokasi dan petunjuk arah selengkapnya di halaman Kontak kami.',
                'kategori' => 'umum',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Apakah sekolah menyediakan layanan antar-jemput?',
                'jawaban' => 'Saat ini sekolah menyediakan fasilitas transportasi jemputan khusus untuk siswa jenjang TK dan SD dengan rute tertentu. Informasi rute dan tarif dapat ditanyakan ke bagian administrasi sekolah.',
                'kategori' => 'umum',
                'urutan' => 3,
            ],

            // Kategori: PPDB
            [
                'pertanyaan' => 'Bagaimana cara mendaftar sebagai siswa baru (PPDB)?',
                'jawaban' => 'Pendaftaran dapat dilakukan secara online melalui menu PPDB di website resmi ini dengan mengisi formulir pendaftaran serta mengunggah dokumen persyaratan, atau datang langsung ke sekretariat pendaftaran di sekolah.',
                'kategori' => 'ppdb',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Apa saja dokumen persyaratan untuk pendaftaran PPDB?',
                'jawaban' => 'Dokumen yang diperlukan meliputi: Akta Kelahiran, Kartu Keluarga, KTP Orang Tua/Wali, Ijazah terakhir/Surat Keterangan Lulus (SKL), dan pas foto terbaru ukuran 3x4.',
                'kategori' => 'ppdb',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Kapan pendaftaran PPDB dibuka dan ditutup?',
                'jawaban' => 'Periode pendaftaran PPDB biasanya dibuka mulai awal tahun ajaran baru (sekitar Januari) hingga kuota kelas terpenuhi. Tanggal aktif pendaftaran saat ini dapat Anda lihat langsung di dashboard halaman utama website ini atau menu PPDB.',
                'kategori' => 'ppdb',
                'urutan' => 3,
            ],

            // Kategori: Akademik
            [
                'pertanyaan' => 'Apa saja jenjang pendidikan yang tersedia di Nuurudzholaam?',
                'jawaban' => 'Kami menyelenggarakan pendidikan terpadu untuk jenjang TK (Taman Kanak-Kanak), SD (Sekolah Dasar), SMP (Sekolah Menengah Pertama), dan SMK (Sekolah Menengah Kejuruan) dengan berbagai pilihan kompetensi keahlian.',
                'kategori' => 'akademik',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Bagaimana sistem pembelajaran sehari-hari?',
                'jawaban' => 'Pembelajaran dilaksanakan dengan sistem Full Day School dari hari Senin hingga Jumat/Sabtu (sesuai jenjang), yang mengintegrasikan kurikulum dinas pendidikan dan program pembiasaan keagamaan seperti shalat dhuha, tadarus, serta tahfidz Al-Qur\'an.',
                'kategori' => 'akademik',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Apakah ada program hafalan (Tahfidz) Al-Qur\'an?',
                'jawaban' => 'Ya, program Tahfidz Al-Qur\'an merupakan salah satu program unggulan kami di seluruh jenjang pendidikan, dengan target hafalan minimal yang disesuaikan untuk setiap tingkatnya.',
                'kategori' => 'akademik',
                'urutan' => 3,
            ],

            // Kategori: Fasilitas
            [
                'pertanyaan' => 'Fasilitas apa saja yang disediakan untuk menunjang pembelajaran?',
                'jawaban' => 'Fasilitas pendukung di Nuurudzholaam meliputi ruang kelas yang nyaman, laboratorium komputer untuk praktek TIK, perpustakaan, masjid/mushola sekolah, lapangan olahraga, area bermain khusus TK, serta lingkungan sekolah yang asri dan aman.',
                'kategori' => 'fasilitas',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Apakah tersedia asrama/pondok bagi siswa?',
                'jawaban' => 'Ya, kami menyediakan fasilitas asrama (pondok pesantren) bagi siswa jenjang SMP dan SMK yang ingin mukim/mondok sambil bersekolah umum. Pembinaan asrama dilakukan oleh ustadz/ustadzah yang berpengalaman.',
                'kategori' => 'fasilitas',
                'urutan' => 2,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(
                ['pertanyaan' => $faq['pertanyaan']],
                $faq
            );
        }
    }
}
