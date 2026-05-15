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
            'status' => 'approved', // ✅ Changed from is_approved
            'is_blocked' => false,
            'spent_amount' => 0,
        ]);

        // 2. Create a Sample Seller (For Testing)
        User::create([
            'name' => 'Espiflor Shop Owner',
            'email' => 'seller@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'shop_name' => 'Espiflor Shop', // ✅ Added for Seller Studio branding
            'status' => 'approved',         // ✅ Changed from is_approved
            'is_blocked' => false,
            'contact_number' => '09123456789',
            'age' => 25,
        ]);

        // 3. Create a Sample Buyer (For Testing)
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'buyer@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'status' => 'approved',
            'grade_level' => 'College',
            'monthly_budget' => '₱2,000.00', // ✅ Added for Smart Budget testing
            'spent_amount' => 0,
        ]);
    }
}