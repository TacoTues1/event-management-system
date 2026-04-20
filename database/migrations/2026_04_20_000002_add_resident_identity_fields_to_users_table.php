<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'contact_number')) {
                $table->string('contact_number', 20)->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'id_type')) {
                $table->string('id_type', 100)->nullable()->after('civil_status');
            }

            if (!Schema::hasColumn('users', 'resident_id_file')) {
                $table->string('resident_id_file')->nullable()->after('id_type');
            }

            if (!Schema::hasColumn('users', 'building_no')) {
                $table->string('building_no', 100)->nullable()->after('purok');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'contact_number')) {
                $table->dropColumn('contact_number');
            }

            if (Schema::hasColumn('users', 'id_type')) {
                $table->dropColumn('id_type');
            }

            if (Schema::hasColumn('users', 'resident_id_file')) {
                $table->dropColumn('resident_id_file');
            }

            if (Schema::hasColumn('users', 'building_no')) {
                $table->dropColumn('building_no');
            }
        });
    }
};
