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
        if (Schema::hasTable('announcements')) {
            if (!Schema::hasColumn('announcements', 'tanggal_mulai')) {
                Schema::table('announcements', function (Blueprint $table) {
                    $table->date('tanggal_mulai')->nullable();
                });
            }

            if (!Schema::hasColumn('announcements', 'tanggal_selesai')) {
                Schema::table('announcements', function (Blueprint $table) {
                    $table->date('tanggal_selesai')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('announcements')) {
            Schema::table('announcements', function (Blueprint $table) {
                if (Schema::hasColumn('announcements', 'tanggal_selesai')) {
                    $table->dropColumn('tanggal_selesai');
                }
                if (Schema::hasColumn('announcements', 'tanggal_mulai')) {
                    $table->dropColumn('tanggal_mulai');
                }
            });
        }
    }
};
