<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE activities MODIFY COLUMN visibility ENUM('publik', 'siswa', 'guru') DEFAULT 'publik'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE activities MODIFY COLUMN visibility ENUM('guru', 'ortu', 'publik') DEFAULT 'publik'");
    }
};
