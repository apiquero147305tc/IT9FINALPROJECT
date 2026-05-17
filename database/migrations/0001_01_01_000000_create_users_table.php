<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // 👤 BASIC ACCOUNT INFO
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->enum('role', ['admin', 'seller', 'buyer'])->default('buyer');
            $table->boolean('is_blocked')->default(0);

            // 🛒 BUYER & SMART BUDGET DATA
            $table->string('grade_level')->nullable(); 
            $table->string('monthly_budget')->nullable(); // The "Limit" set by user
            $table->decimal('spent_amount', 10, 2)->default(0); // Total actual spending
            $table->json('category_spending')->nullable(); // Stores { "Food": 50, "Tools": 100 }

            // 🏪 SELLER-SPECIFIC DATA
            $table->string('shop_name')->nullable();
            $table->integer('age')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('valid_id')->nullable(); // Stores path to the uploaded file

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};