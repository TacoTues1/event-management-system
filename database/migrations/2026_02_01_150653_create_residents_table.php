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
        Schema::create('residents', function (Blueprint $table) {
            $table->id('resident_id');
            $table->string('full_name', 150);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->integer('age');
            $table->string('civil_status', 20);
            $table->string('purok', 100);
            $table->string('barangay', 100)->default('Bagacay');
            $table->string('city', 100)->default('Dumaguete City');
            $table->string('indigent_status', 20);
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
