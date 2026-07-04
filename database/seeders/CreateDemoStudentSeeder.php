<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class CreateDemoStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user siswa
        $user = User::firstOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Siswa Demo',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'phone' => '08123456789',
                'address' => 'Jalan Demo No. 123',
            ]
        );

        // Buat student record jika belum ada
        Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nisn' => '1234567890123',
                'class' => '10',
            ]
        );

        echo "\n✅ Demo student created!\n";
        echo "Email: siswa@example.com\n";
        echo "Password: password\n";
    }
}
