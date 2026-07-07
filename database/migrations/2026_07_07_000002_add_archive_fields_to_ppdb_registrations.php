<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('status');
            $table->integer('archive_year')->nullable()->after('is_archived');
        });
    }

    public function down()
    {
        Schema::table('ppdb_registrations', function (Blueprint $table) {
            $table->dropColumn(['is_archived', 'archive_year']);
        });
    }
};
