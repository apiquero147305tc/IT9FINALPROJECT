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
            // This ensures only the seller who owns the product can edit it.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. Basic Item Details
            $table->string('name');
            $table->text('description')->nullable(); 
            $table->decimal('price', 10, 2); 
            $table->integer('stock')->default(0); 
            
            // 3. Organization & Visuals
            // Change category to string so sellers can type their own or pick from a list
            $table->string('category')->default('General'); 
            
            // This stores the path to the item picture in the 'storage' folder
            $table->string('image')->nullable(); 
            
            // 4. Status 
            // Useful for showing "Sold Out" or "Hidden"
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