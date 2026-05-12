<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            ! Schema::hasTable('users') ||
            ! Schema::hasColumn('users', 'email') ||
            ! Schema::hasColumn('users', 'is_archived')
        ) {
            return;
        }

        DB::table('users')
            ->where('role', 'resident')
            ->where('is_archived', true)
            ->whereIn('email', [
                'alfonzperez94@gmail.com',
                'alfonzperez92@gmail.com',
            ])
            ->delete();
    }

    public function down(): void
    {
        // Data deletion cannot be restored automatically.
    }
};
