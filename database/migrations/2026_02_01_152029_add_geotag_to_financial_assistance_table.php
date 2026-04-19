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
        Schema::table('financial_assistance', function (Blueprint $table) {
            $table->unsignedBigInteger('geotag_id')->nullable()->after('approved_by');
            
            $table->foreign('geotag_id')
                  ->references('geotag_id')
                  ->on('geotags')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_assistance', function (Blueprint $table) {
            $table->dropForeign(['geotag_id']);
            $table->dropColumn('geotag_id');
        });
    }
};
