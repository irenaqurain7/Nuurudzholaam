<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('jenjang')->nullable()->after('specialization');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->string('grade')->nullable()->change(); // Allow non-numeric
            $table->string('kategori')->nullable()->after('grade');
            $table->string('deskripsi')->nullable()->after('kategori');
            $table->string('jenis_penilaian')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('jenjang');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'deskripsi', 'jenis_penilaian']);
        });
    }
};
