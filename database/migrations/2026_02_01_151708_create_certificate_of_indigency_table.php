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
        Schema::create('certificate_of_indigency', function (Blueprint $table) {
            $table->id('certificate_id');
            $table->unsignedBigInteger('document_id')->unique();
            $table->date('validity_date');
            $table->timestamps();

            $table->foreign('document_id')
                  ->references('document_id')
                  ->on('documents')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_of_indigency');
    }
};
