<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteBukaBersamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::where('judul', 'LIKE', '%Buka Bersama%')->delete();
        Activity::where('judul', 'LIKE', '%Iftar%')->delete();
    }
}
