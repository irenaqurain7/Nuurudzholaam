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
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->enum('jenjang', ['tk', 'sd', 'smp', 'smk'])->after('id')->default('tk');
            $table->string('nisn')->nullable()->after('nama_lengkap');
            $table->string('nik')->nullable()->after('nisn');
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->after('tempat_lahir')->default('laki-laki');
            $table->string('nama_ayah')->nullable()->after('asal_sekolah');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->string('jurusan')->nullable()->after('program');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'jenjang',
                'nisn',
                'nik',
                'tempat_lahir',
                'jenis_kelamin',
                'nama_ayah',
                'nama_ibu',
                'jurusan'
            ]);
        });
    }
};
