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
        $validPuroks = ['Purok Mahigugma-on', 'Purok Gumamela', 'Purok Santol', 'Purok Cebasca', 'Purok Fuente', 'Admin Office'];
        
        \DB::table('users')->whereNotIn('purok', $validPuroks)->delete();
        \DB::table('residents')->whereNotIn('purok', $validPuroks)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
