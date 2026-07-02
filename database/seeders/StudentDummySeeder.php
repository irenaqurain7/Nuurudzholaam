<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentDummySeeder extends Seeder
{
    private function generateUniqueNisn(string $baseNisn, int $userId): string
    {
        $candidate = $baseNisn;

        while (Student::where('nisn', $candidate)->where('user_id', '!=', $userId)->exists()) {
            $numeric = (int) $candidate;
            $candidate = str_pad((string) ($numeric + 1), 13, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruUser = User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Test Guru',
                'username' => 'guru',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        $teacher = Teacher::updateOrCreate(
            ['user_id' => $guruUser->id],
            [
                'nip' => '19800515200501001',
                'specialization' => 'Matematika',
            ]
        );

        $subjects = ['Matematika', 'Bahasa Indonesia', 'IPA'];

        $data = [
            '1A' => [
                ['1001', 'Ahmad Fauzan'],
                ['1002', 'Siti Aisyah'],
                ['1003', 'Rizky Maulana'],
                ['1004', 'Nayla Putri'],
                ['1005', 'Fajar Ramadhan'],
                ['1006', 'Zahra Safitri'],
                ['1007', 'Dimas Pratama'],
                ['1008', 'Alya Maharani'],
                ['1009', 'Rafi Akbar'],
                ['1010', 'Citra Lestari'],
            ],
            '2A' => [
                ['2001', 'Bagas Saputra'],
                ['2002', 'Intan Permata'],
                ['2003', 'M. Farhan'],
                ['2004', 'Salsa Nabila'],
                ['2005', 'Reza Kurniawan'],
                ['2006', 'Keisya Amanda'],
                ['2007', 'Ilham Hidayat'],
                ['2008', 'Tiara Anindya'],
                ['2009', 'Aldi Firmansyah'],
                ['2010', 'Putri Amelia'],
            ],
            '3A' => [
                ['3001', 'Yusuf Maulana'],
                ['3002', 'Nabila Azzahra'],
                ['3003', 'Andika Prasetyo'],
                ['3004', 'Bella Oktaviani'],
                ['3005', 'Hafiz Ramadhan'],
                ['3006', 'Syifa Rahma'],
                ['3007', 'Galang Wijaya'],
                ['3008', 'Nurul Aini'],
                ['3009', 'Kevin Saputra'],
                ['3010', 'Larasati Putri'],
            ],
            '4A' => [
                ['4001', 'Aditiya Nugraha'],
                ['4002', 'Vania Kirana'],
                ['4003', 'Arga Pratama'],
                ['4004', 'Melati Salsabila'],
                ['4005', 'Daffa Alghifari'],
                ['4006', 'Rania Putri'],
                ['4007', 'Fikri Hidayat'],
                ['4008', 'Anisa Maharani'],
                ['4009', 'Rio Saputro'],
                ['4010', 'Aurelia Putri'],
            ],
            '5A' => [
                ['5001', 'M. Rizwan'],
                ['5002', 'Kayla Anjani'],
                ['5003', 'Bima Prakoso'],
                ['5004', 'Felicia Amanda'],
                ['5005', 'Rangga Saputra'],
                ['5006', 'Dinda Ayuningtyas'],
                ['5007', 'Akmal Firdaus'],
                ['5008', 'Shella Oktavia'],
                ['5009', 'Raka Maulana'],
                ['5010', 'Nadine Putri'],
            ],
            '6A' => [
                ['6001', 'Alif Ramadhan'],
                ['6002', 'Jasmine Aulia'],
                ['6003', 'Fahri Saputra'],
                ['6004', 'Celine Maharani'],
                ['6005', 'Zidan Pratama'],
                ['6006', 'Shakira Nabila'],
                ['6007', 'Wahyu Hidayat'],
                ['6008', 'Tasya Putri'],
                ['6009', 'Arya Nugroho'],
                ['6010', 'Salma Azzahra'],
            ],
        ];

        foreach ($data as $class => $students) {
            foreach ($students as $index => $item) {
                [$nis, $name] = $item;

                $username = 's' . $nis;
                $email = $username . '@dummy.local';

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'username' => $username,
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'role' => 'siswa',
                        'nisn' => $nis,
                        'class' => $class,
                        'is_active' => true,
                    ]
                );

                $student = Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nisn' => $nis,
                        'class' => $class,
                    ]
                );

                foreach ($subjects as $subjectIndex => $subject) {
                    $gradeValue = 70 + (($index * 7 + $subjectIndex * 5 + (int) substr($nis, -1)) % 26);

                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject' => $subject,
                        ],
                        [
                            'grade' => $gradeValue,
                            'notes' => 'Nilai dummy untuk ' . $subject,
                        ]
                    );
                }
            }
        }

        // Ensure existing siswa users (e.g. manual/test accounts) also have student + grades.
        $existingStudentUsers = User::where('role', 'siswa')->get();

        foreach ($existingStudentUsers as $studentUser) {
            $class = (string) ($studentUser->class ?: '10A');
            $baseNisn = preg_replace('/\D+/', '', (string) $studentUser->nisn);
            if (!$baseNisn) {
                $baseNisn = str_pad((string) (9000000000000 + (int) $studentUser->id), 13, '0', STR_PAD_LEFT);
            }
            $nisn = $this->generateUniqueNisn(str_pad(substr($baseNisn, 0, 13), 13, '0', STR_PAD_LEFT), $studentUser->id);

            $student = Student::updateOrCreate(
                ['user_id' => $studentUser->id],
                [
                    'nisn' => $nisn,
                    'class' => $class,
                ]
            );

            foreach ($subjects as $subjectIndex => $subject) {
                $gradeValue = 72 + ((($student->id * 3) + ($subjectIndex * 7)) % 24);

                Grade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'teacher_id' => $teacher->id,
                        'subject' => $subject,
                    ],
                    [
                        'grade' => $gradeValue,
                        'notes' => 'Nilai dummy untuk akun siswa existing',
                    ]
                );
            }
        }
    }
}
