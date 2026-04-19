<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['request_id']);
        });
        
        Schema::dropIfExists('document_requests');
        
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedInteger('resident_id');
            $table->text('purpose');
            $table->date('request_date');
            $table->string('status', 50)->default('pending');
            $table->timestamps();

            $table->foreign('resident_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('request_id')
                  ->references('request_id')
                  ->on('document_requests')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};