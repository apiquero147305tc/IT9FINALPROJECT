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
        Schema::table('users', function (Blueprint $table) {
            // Role identifies if the user is an admin, seller, or buyer
            $table->string('role')->default('buyer')->after('email'); 
            
            // Spending limit for buyers (allows for 10 digits total, 2 after the decimal)
            $table->decimal('spending_limit', 10, 2)->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the columns if the migration is rolled back
            $table->dropColumn(['role', 'spending_limit']);
        });
    }
};