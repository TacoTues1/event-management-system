<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['resident_id']);
        });
        
        Schema::table('document_requests', function (Blueprint $table) {
            // Change column type to match users.user_id (unsigned integer)
            $table->unsignedInteger('resident_id')->change();
            
            // Add new foreign key constraint referencing users table
            $table->foreign('resident_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['resident_id']);
            
            // Change back to unsignedBigInteger
            $table->unsignedBigInteger('resident_id')->change();
            
            // Restore the original foreign key constraint
            $table->foreign('resident_id')
                  ->references('resident_id')
                  ->on('residents')
                  ->onDelete('cascade');
        });
    }
};