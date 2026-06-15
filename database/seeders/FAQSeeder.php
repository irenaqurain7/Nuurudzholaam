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
                'jawaban' => 'Nuurudzholaam (Nuzo) adalah pondok pesantren dan lembaga pendidikan Islam terpadu yang menyelenggarakan program pendidikan mulai dari TK, SD, SMP, SMK hingga pondok pesantren dengan memadukan kurikulum berbasis pesantren dan formal.',
                'kategori' => 'umum',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Di mana lokasi sekolah Nuurudzholaam?',
                'jawaban' => 'Sekolah Nuurudzholaam berlokasi di Kp, Jl. Sindang reret, Dangdeur, Kec. Bungursari, Kab. Purwakarta, Jawa Barat 41181.',
                'kategori' => 'umum',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Berapa biaya pendidikan untuk sekolah?',
                'jawaban' => 'Mengenai biaya pendidikan anda bisa langsung tanyakan kepada admin dengan cara menghubungi nomor yang tertera dan untuk anak yatim dan piatu biaya pendidikan gratis atau di tanggung oleh lembaga (yayasan).',
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
                'jawaban' => 'Pembelajaran dilaksanakan dengan sistem Full Day School dari hari Senin hingga Jumat  yang mengintegrasikan kurikulum dinas pendidikan dan program pembiasaan keagamaan seperti shalat dhuha berjama\'ah setiap hari, Apel pagi setiap hari senin, hapalan zuz amma setiap hari selasa, senam gembira setiap hari rabu, kegiatan literasi setiap hari kamis serta olahraga bersama setiap hari jumat dan seluruh kegiatan di laksanakan sebelum pembelajaran dimulai.',
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
                'jawaban' => 'Fasilitas pendukung di Nuurudzholaam meliputi ruang kelas yang nyaman, lab komputer untuk praktek TIK, perpustakaan, masjid sekolah, lapangan olahraga, area bermain khusus TK, Kantin sekolah, BLK (Balai latihan kerja), asrama putra putri atau pondok pesantren serta lingkungan sekolah yang asri dan aman.',
                'kategori' => 'fasilitas',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Apakah tersedia asrama/pondok bagi siswa?',
                'jawaban' => 'Ya, kami menyediakan fasilitas asrama (pondok pesantren) bagi siswa dan siswi yang ingin mondok sambil bersekolah umum. Pembinaan asrama dilakukan oleh ustadz/ustadzah yang berpengalaman.',
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
