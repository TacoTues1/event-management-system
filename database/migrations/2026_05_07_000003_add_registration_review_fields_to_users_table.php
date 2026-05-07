<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'registration_status')) {
                $table->string('registration_status', 20)
                    ->default('approved')
                    ->after('is_archived');
            }

            if (!Schema::hasColumn('users', 'registration_rejection_reason')) {
                $table->text('registration_rejection_reason')
                    ->nullable()
                    ->after('registration_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'registration_rejection_reason')) {
                $table->dropColumn('registration_rejection_reason');
            }

            if (Schema::hasColumn('users', 'registration_status')) {
                $table->dropColumn('registration_status');
            }
        });
    }
};
