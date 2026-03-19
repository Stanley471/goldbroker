<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $admin = User::create([
        'first_name' => 'Stanley',
        'last_name' => 'Admin',
        'email' => 'stanley@goldbrokers.com',
        'password' => bcrypt('yourpassword'),
        'email_verified_at' => now(),
    ]);

    $admin->assignRole('admin');
}
}
