<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the PRE-SET ADMIN
        User::create([
            'name' => 'CraveCart Admin',
            'email' => 'admin@cravecart.com',
            'password' => 'admin123',
            'role' => 'admin',
            'status' => 'approved', // Match the check in your AuthController
            'is_blocked' => false,
        ]);

        // 2. Create a Sample Seller
        User::create([
            'name' => 'Espiflor Shop',
            'email' => 'seller@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'status' => 'approved',
            'shop_name' => 'Espiflor Studio',
            'is_blocked' => false,
        ]);

        // 3. Create a Sample Buyer
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'buyer@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'approved',
            'is_blocked' => false,
        ]);
    }
}