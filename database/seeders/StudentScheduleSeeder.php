<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentSchedule;

class StudentScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Monday' => [
                'Sholat Dhuha',
                'Upacara Bendera',
                'Pendidikan Pancasila',
                'Istirahat',
                'Bahasa Indonesia',
            ],
            'Tuesday' => [
                'Sholat Dhuha',
                'Pembiasaan Ngosrek',
                'Pendidikan Agama Islam',
                'Istirahat',
                'Matematika',
            ],
            'Wednesday' => [
                'Sholat Dhuha',
                'Kaulinan Sunda',
                'Istirahat',
                'Bahasa Sunda',
            ],
            'Thursday' => [
                'Sholat Dhuha',
                'Pembiasaan Literasi',
                'Seni Budaya',
                'Istirahat',
                'Huruf Sambung',
            ],
            'Friday' => [
                'Sholat Dhuha',
                'PJOK',
                'Istirahat',
                'TDBA / 8 Dimensi Profil Lulusan',
            ],
        ];

        $targetClasses = ['2', '10'];

        foreach ($targetClasses as $class) {
            foreach ($data as $day => $activities) {
                StudentSchedule::updateOrCreate([
                    'class' => $class,
                    'day' => $day,
                ], [
                    'activities' => $activities,
                ]);
            }
        }
    }
}
