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
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->unsignedBigInteger('resident_id');
            $table->text('purpose');
            $table->date('request_date');
            $table->string('status', 50)->default('pending');
            $table->timestamps();

            $table->foreign('resident_id')
                  ->references('resident_id')
                  ->on('residents')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
