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
        Schema::create('financial_assistance', function (Blueprint $table) {
            $table->id('assistance_id');
            $table->unsignedBigInteger('resident_id');
            $table->string('assistance_type', 100);
            $table->decimal('amount', 10, 2);
            $table->date('date_granted');
            $table->text('remarks')->nullable();
            $table->string('status', 50)->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('resident_id')
                  ->references('resident_id')
                  ->on('residents')
                  ->onDelete('cascade');
                  
            $table->foreign('approved_by')
                  ->references('admin_id')
                  ->on('admins')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_assistance');
    }
};
