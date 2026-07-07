<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('is_active');
            $table->integer('graduation_year')->nullable()->after('is_archived');
            $table->integer('archive_year')->nullable()->after('graduation_year');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_archived', 'graduation_year', 'archive_year']);
        });
    }
};
