<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@bagacay.gov.ph',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
            'age' => 35,
            'civil_status' => 'Single',
            'purok' => 'Admin Office',
            'barangay' => 'Bagacay',
            'city' => 'Dumaguete City',
            'is_indigent' => 'No',
            'purpose' => 'System Administrator',
            'date_issued' => now()->format('Y-m-d'),
        ]);
    }
}
