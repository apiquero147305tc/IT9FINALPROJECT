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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            
            // 👤 Connects the cart item to a User
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 📦 Connects the cart item to a Product
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // 🔢 Stores how many of this item the buyer wants
            $table->integer('quantity')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};