<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test guru user
        $guruUser = User::where('email', 'guru@example.com')->first();
        
        if ($guruUser) {
            // Create teacher record if not exists
            Teacher::updateOrCreate(
                ['user_id' => $guruUser->id],
                [
                    'nip' => '19800515200501001',
                    'specialization' => 'Matematika',
                ]
            );
        }

        // Optionally add more teachers
        $adminUser = User::where('email', 'admin@nuurudzholaam.sch.id')->first();
        if ($adminUser && $adminUser->role === 'guru') {
            Teacher::updateOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'nip' => '19750810199203001',
                    'specialization' => 'Bahasa Indonesia',
                ]
            );
        }
    }
}
