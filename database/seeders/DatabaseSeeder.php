<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the PRE-SET ADMIN
            User::create([
            'name' => 'CraveCart Admin',
            'email' => 'admin@cravecart.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_approved' => true,
            'is_blocked' => false,
]);

        // 2. Create a Sample Seller (For Testing)
            User::create([
            'name' => 'Espiflor Shop',
            'email' => 'seller@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'is_approved' => true,
            'is_blocked' => false,
        ]);

        // 3. Create a Sample Buyer (For Testing)
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'buyer@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'is_approved' => true,
            'is_blocked' => false,

        ]);
    }
}
