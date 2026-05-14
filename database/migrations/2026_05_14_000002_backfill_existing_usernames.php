<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $users = DB::table('users')
            ->select('id', 'name', 'username')
            ->whereNull('username')
            ->orWhere('username', '')
            ->get();

        foreach ($users as $user) {
            $base = strtolower((string) preg_replace('/[^a-zA-Z0-9_]+/', '_', trim((string) $user->name)));
            $base = trim($base, '_');

            if ($base === '') {
                $base = 'user';
            }

            // Ensure uniqueness for existing data by appending user id.
            $username = $base . '_' . $user->id;

            DB::table('users')
                ->where('id', $user->id)
                ->update(['username' => $username]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty. Do not unset usernames after backfill.
    }
};
