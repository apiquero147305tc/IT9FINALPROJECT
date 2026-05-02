<?php

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
=======
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

>>>>>>> 4de1883d5dbe8b6824d22131dd8b470cc5952cf0
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // 1. Create the PRE-SET ADMIN
        User::create([
            'name' => 'CraveCart Admin',
            'email' => 'admin@cravecart.com',
            'password' => Hash::make('admin123'), // Use 'admin123' to log in
            'role' => 'admin',
        ]);

        // 2. Create a Sample Seller (For Testing)
        User::create([
            'name' => 'Espiflor Shop',
            'email' => 'seller@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);

        // 3. Create a Sample Buyer (For Testing)
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'buyer@cravecart.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);
    }
}
=======
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> 4de1883d5dbe8b6824d22131dd8b470cc5952cf0
