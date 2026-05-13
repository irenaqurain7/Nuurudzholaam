<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@nuurudzholaam.sch.id'],
            [
                'name' => 'Admin Nuurudzholaam',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create test students
        User::updateOrCreate(
            ['email' => 'siswa@example.com'],
            [
                'name' => 'Test Siswa',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'siswa',
                'is_active' => true,
            ]
        );

        // Create test guru
        User::updateOrCreate(
            ['email' => 'guru@example.com'],
            [
                'name' => 'Test Guru',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        // Create test orangtua
        User::updateOrCreate(
            ['email' => 'orangtua@example.com'],
            [
                'name' => 'Test Orang Tua',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'orangtua',
                'is_active' => true,
            ]
        );
    }
}
