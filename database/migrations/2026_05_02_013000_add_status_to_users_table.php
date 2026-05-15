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
<<<<<<< HEAD
        // CHECK IF COLUMN EXISTS FIRST
        if (!Schema::hasColumn('users', 'status')) {

            Schema::table('users', function (Blueprint $table) {

                $table->string('status')
                      ->default('approved')
                      ->after('role');

            });

        }
=======
        Schema::table('users', function (Blueprint $table) {
            // This adds the status column after the 'role' column.
            // We set the default to 'pending' to require Admin approval.
            $table->string('status')->default('pending')->after('role');
        });
>>>>>>> origin/SellerStartup2.0
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD
        // CHECK BEFORE DROPPING
        if (Schema::hasColumn('users', 'status')) {

            Schema::table('users', function (Blueprint $table) {

                $table->dropColumn('status');

            });

        }
=======
        Schema::table('users', function (Blueprint $table) {
            // This allows you to roll back the migration if needed.
            $table->dropColumn('status');
        });
>>>>>>> origin/SellerStartup2.0
    }
};