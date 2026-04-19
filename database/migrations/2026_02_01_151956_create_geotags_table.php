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
        Schema::create('geotags', function (Blueprint $table) {
            $table->id('geotag_id');
            $table->unsignedBigInteger('resident_id');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('location_address');
            $table->timestamp('timestamp');
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
        Schema::dropIfExists('geotags');
    }
};
