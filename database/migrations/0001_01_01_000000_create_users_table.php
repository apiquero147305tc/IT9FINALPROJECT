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

            // BASIC INFO
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // ROLE SYSTEM
            $table->enum('role', ['admin', 'seller', 'buyer'])->default('buyer');

            // BUYER DATA
            $table->string('grade_level')->nullable();
            $table->string('monthly_budget')->nullable();

            // 🧠 SMART BUDGET FIELD
            $table->decimal('spent_amount', 10, 2)->default(0);

            // IMPORTANT:
            // ❌ shop_name REMOVED to avoid duplicate column error
            // It should only exist in seller-specific migration if needed

            $table->rememberToken();
            $table->timestamps();
        });

        // PASSWORD RESET TABLE
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // SESSIONS TABLE
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