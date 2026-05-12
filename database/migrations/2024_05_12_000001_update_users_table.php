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
        Schema::table('users', function (Blueprint $table) {
            // Add role column (student, teacher, admin)
            $table->enum('role', ['student', 'teacher', 'admin'])->default('student')->after('email');

            // Add profile fields
            $table->string('phone')->nullable()->after('role');
            $table->string('address')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('address');
            $table->string('profile_photo')->nullable()->after('bio');

            // For students
            $table->string('nisn')->nullable()->unique()->after('profile_photo');
            $table->string('class')->nullable()->after('nisn');

            // For teachers
            $table->string('nip')->nullable()->unique()->after('class');
            $table->string('specialization')->nullable()->after('nip');

            // Account status
            $table->boolean('is_active')->default(true)->after('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'phone',
                'address',
                'bio',
                'profile_photo',
                'nisn',
                'class',
                'nip',
                'specialization',
                'is_active'
            ]);
        });
    }
};
