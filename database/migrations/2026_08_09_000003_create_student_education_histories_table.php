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
        Schema::create('student_education_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('academic_year');
            $table->enum('jenjang', ['TK', 'SD', 'SMP', 'SMK']);
            $table->string('class')->nullable();
            $table->enum('status', ['Naik Kelas','Lanjut','Tidak Naik','Pindah Sekolah','Tidak Lanjut','Belum Ditentukan','Lulus'])->default('Belum Ditentukan');
            $table->text('note')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['student_id','academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_education_histories');
    }
};
