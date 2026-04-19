<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agricultural_certifications', function (Blueprint $table) {
            $table->id();

            // INT foreign key
            $table->unsignedInteger('user_id')->nullable();

            $table->string('association_name', 150)->nullable();

            $table->boolean('is_certified_farmer')->nullable();
            $table->decimal('farm_area_hectares', 6, 2)->nullable();
            $table->string('farm_barangay', 100)->nullable();

            $table->string('crops_planted')->nullable();
            $table->string('land_owner_name', 150)->nullable();

            $table->boolean('raises_livestock')->nullable();

            $table->boolean('is_farm_worker')->nullable();
            $table->string('farm_owner_name', 150)->nullable();

            $table->string('purpose')->nullable();

            $table->unsignedTinyInteger('issued_day')->nullable();
            $table->string('issued_month', 20)->nullable();
            $table->unsignedSmallInteger('issued_year')->nullable();

            $table->timestamp('issued_at')->nullable();

            $table->timestamps();

            // FK constraint (INT → INT)
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agricultural_certifications');
    }
};
