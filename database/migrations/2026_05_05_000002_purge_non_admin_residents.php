<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            DB::table('users')
                ->where(function ($query): void {
                    $query->whereNull('role')
                        ->orWhere('role', '!=', 'admin');
                })
                ->delete();
        }

        // Keep the legacy residents table in sync with a resident purge.
        if (Schema::hasTable('residents')) {
            DB::table('residents')->delete();
        }
    }

    public function down(): void
    {
        // Data-destructive migration; rows cannot be restored automatically.
    }
};
