<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('collateral_product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->date('borrow_date');
            $table->date('return_date');
            $table->enum('status', ['pending', 'approved', 'active', 'returned', 'damaged', 'rejected'])->default('pending');
            $table->text('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->enum('condition_on_return', ['good', 'damaged', 'lost'])->nullable();
            $table->text('damage_description')->nullable();
            $table->boolean('collateral_released')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};