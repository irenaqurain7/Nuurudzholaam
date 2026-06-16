<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'nama_program' => 'Program Tahfiz Al-Qur\'an',
                'deskripsi' => 'Program khusus untuk menghafal Al-Qur\'an dengan metode modern dan terbukti efektif. Siswa akan dibimbing oleh guru berpengalaman untuk mencapai hafalan 30 juz dengan pemahaman makna yang mendalam.',
                'kurikulum' => 'Kombinasi pendekatan tradisional (Talaqqi) dengan metode modern, ditambah pembelajaran tajweed, tafsir, dan hadis untuk penguatan pemahaman.',
                'gambar' => null,
                'kuota' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_program' => 'Program IPA Terpadu',
                'deskripsi' => 'Program sains yang mengintegrasikan Fisika, Kimia, dan Biologi dengan perspektif Islam. Pembelajaran berbasis proyek dan eksperimen untuk meningkatkan pemahaman konsep sains.',
                'kurikulum' => 'Kurikulum Nasional dengan enrichment materi sains terkini, laboratorium lengkap, dan pembelajaran yang menghubungkan sains dengan ajaran Islam.',
                'gambar' => null,
                'kuota' => 35,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_program' => 'Program Keunggulan Bahasa',
                'deskripsi' => 'Program intensif untuk menguasai Bahasa Inggris, Arab, dan Mandarin. Siswa akan belajar dari native speakers dan berpartisipasi dalam berbagai kompetisi tingkat nasional.',
                'kurikulum' => 'Pembelajaran bahasa tematik, conversation practice, cultural immersion, dan persiapan sertifikasi internasional seperti TOEFL dan Cambridge.',
                'gambar' => null,
                'kuota' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_program' => 'Program Entrepreneurship Digital',
                'deskripsi' => 'Program inovatif untuk mengembangkan keterampilan digital dan kewirausahaan. Siswa akan belajar membuat website, aplikasi, dan mengembangkan bisnis online mereka sendiri.',
                'kurikulum' => 'Web development, mobile app development, digital marketing, e-commerce, dan startup mentoring dari praktisi industri.',
                'gambar' => null,
                'kuota' => 28,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('programs')->insert($programs);
    }
}
