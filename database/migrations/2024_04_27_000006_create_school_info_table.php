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
        Schema::create('school_info', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->text('deskripsi');
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_info');
    }
};
