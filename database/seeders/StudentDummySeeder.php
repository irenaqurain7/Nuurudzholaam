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
        // Dummy student seeding telah dinonaktifkan untuk mencegah data palsu muncul di admin.
    }
}
