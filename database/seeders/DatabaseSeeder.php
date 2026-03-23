<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vault;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    if (!\App\Models\User::where('email', 'stanley@goldbrokers.com')->exists()) {
    $admin = User::create([
        'first_name' => 'Stanley',
        'last_name' => 'Admin',
        'email' => 'stanley@goldbrokers.com',
        'password' => bcrypt('yourpassword'),
        'email_verified_at' => now(),
    ]);

    $admin->assignRole('admin');
}


// Seed vaults
Vault::insert([
    [
        'name' => 'Zurich Vault',
        'city' => 'Zurich',
        'country' => 'Switzerland',
        'country_code' => 'CH',
        'address' => 'Bahnhofstrasse 1, 8001 Zurich, Switzerland',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Singapore Vault',
        'city' => 'Singapore',
        'country' => 'Singapore',
        'country_code' => 'SG',
        'address' => '1 Raffles Place, Singapore 048616',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'New York Vault',
        'city' => 'New York',
        'country' => 'United States',
        'country_code' => 'US',
        'address' => '11 Wall Street, New York, NY 10005',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'London Vault',
        'city' => 'London',
        'country' => 'United Kingdom',
        'country_code' => 'GB',
        'address' => '1 Royal Exchange, London EC3V 3DG',
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
}
}