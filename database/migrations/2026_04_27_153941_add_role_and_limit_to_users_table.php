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

        // Only add role if it doesn't exist yet
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('buyer')->after('email');
        }

        // Only add spending_limit if it doesn't exist yet
        if (!Schema::hasColumn('users', 'spending_limit')) {
            $table->decimal('spending_limit', 10, 2)
                  ->nullable()
                  ->after('role');
        }
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