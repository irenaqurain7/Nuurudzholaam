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
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('no_telepon');
            $table->string('asal_sekolah');
            $table->string('nama_ortu');
            $table->string('no_ortu');
            $table->date('tanggal_lahir');
            $table->enum('program', ['ipa', 'ips', 'keagamaan'])->default('keagamaan');
            $table->text('alamat');
            $table->string('file_ijazah')->nullable();
            $table->string('file_ktp')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
    }
};
