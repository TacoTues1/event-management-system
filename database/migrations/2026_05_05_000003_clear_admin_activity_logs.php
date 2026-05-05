<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_logs')) {
            DB::table('admin_logs')->delete();
        }
    }

    public function down(): void
    {
        // Destructive operation; deleted logs cannot be restored.
    }
};
