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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // 1. Link to the Seller (The user who posted it)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. Basic Item Details
            $table->string('name');
            $table->text('description')->nullable(); // Good for more details
            $table->decimal('price', 10, 2); // Increased to 10 for larger prices
            $table->integer('stock')->default(0); // Tracking inventory
            
            // 3. Organization & Visuals
            $table->string('category')->default('General');
            $table->string('image')->nullable();
            
            // 4. Status (Optional: helpful for 'Lending' vs 'Selling')
            $table->string('status')->default('available'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};