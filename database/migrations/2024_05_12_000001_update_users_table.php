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
            // Add role column (admin, guru, orangtua, siswa)
            $table->enum('role', ['admin', 'guru', 'orangtua', 'siswa'])->default('siswa')->after('email');

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

            // For parent
            $table->unsignedBigInteger('parent_id')->nullable()->after('specialization');

            // Account status
            $table->boolean('is_active')->default(true)->after('parent_id');
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
