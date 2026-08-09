<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;

class StudentDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a few siswa users with related student records for testing
        $samples = [
            ['name' => 'Siswa Satu', 'email' => 'siswa1@example.com', 'jenjang' => 'SD', 'class' => '1'],
            ['name' => 'Siswa Dua', 'email' => 'siswa2@example.com', 'jenjang' => 'SD', 'class' => '2'],
            ['name' => 'Siswa Tiga', 'email' => 'siswa3@example.com', 'jenjang' => 'SD', 'class' => '3'],
            ['name' => 'Siswa Empat', 'email' => 'siswa4@example.com', 'jenjang' => 'SD', 'class' => '4'],
            ['name' => 'Siswa Lima', 'email' => 'siswa5@example.com', 'jenjang' => 'SD', 'class' => '5'],
            ['name' => 'Siswa Enam', 'email' => 'siswa6@example.com', 'jenjang' => 'SD', 'class' => '6'],
        ];

        foreach ($samples as $s) {
            // Skip if user already exists
            $user = User::where('email', $s['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $s['name'],
                    'email' => $s['email'],
                    'password' => Hash::make('password'),
                    'role' => 'siswa',
                    'is_active' => true,
                ]);
            }

            // Create or update student record
            $student = Student::where('user_id', $user->id)->first();
            if (!$student) {
                Student::create([
                    'user_id' => $user->id,
                    'jenjang' => $s['jenjang'],
                    'nisn' => 'NISN' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'class' => $s['class'],
                ]);
            } else {
                $student->update(['jenjang' => $s['jenjang'], 'class' => $s['class']]);
            }
        }
    }
}

