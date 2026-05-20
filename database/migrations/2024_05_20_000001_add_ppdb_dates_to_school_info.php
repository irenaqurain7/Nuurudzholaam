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
        Schema::table('school_info', function (Blueprint $table) {
            $table->date('ppdb_start_date')->nullable()->comment('Tanggal mulai PPDB');
            $table->date('ppdb_end_date')->nullable()->comment('Tanggal akhir PPDB');
            $table->boolean('ppdb_active')->default(false)->comment('Status aktivasi PPDB');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_info', function (Blueprint $table) {
            $table->dropColumn(['ppdb_start_date', 'ppdb_end_date', 'ppdb_active']);
        });
    }
};
