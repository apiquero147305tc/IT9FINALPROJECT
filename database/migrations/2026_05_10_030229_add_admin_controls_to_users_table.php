<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Seller approval system
            $table->boolean('is_approved')->default(false);

            // Block/unblock system
            $table->boolean('is_blocked')->default(false);

            // Optional status tracking (cleaner alternative later)
            // $table->string('status')->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'is_approved',
                'is_blocked',
                'shop_name',
                'seller_name',
                'contact_number',
                'valid_id',
            ]);
        });
    }
};