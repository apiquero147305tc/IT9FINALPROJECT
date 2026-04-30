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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // The person buying (Buyer)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // The product being bought
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); 
            
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2); // Handles prices up to 99,999,999.99
            
            // Order tracking status
            $table->string('status')->default('pending'); // e.g., pending, completed, cancelled
            
            // Optional: for students to leave a note (e.g., "Meet at the UM Gate 1")
            $table->text('order_notes')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};