<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('user_id'); // PK

            // Existing (old) fields
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('role', 50)->default('resident');

            // Certificate of Indigency fields
            $table->integer('age')->nullable();
            $table->string('civil_status', 20);

            $table->string('purok', 100);
            $table->string('barangay', 100)->default('Bagacay');
            $table->string('city', 100)->default('Dumaguete City');

            $table->string('is_indigent', 20);

            $table->text('purpose');
            $table->date('date_issued');

            // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
