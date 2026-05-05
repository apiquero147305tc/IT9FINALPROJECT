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

            // Add role only if it does not exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('buyer')->after('email');
            }

            // Add spending_limit only if it does not exist
            if (!Schema::hasColumn('users', 'spending_limit')) {
                $table->decimal('spending_limit', 10, 2)->nullable()->after('role');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'spending_limit']);
        });
    }
};