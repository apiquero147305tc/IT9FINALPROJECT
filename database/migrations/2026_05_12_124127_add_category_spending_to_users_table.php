<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'category_spending')) {

            Schema::table('users', function (Blueprint $table) {

                $table->longText('category_spending')->nullable();

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'category_spending')) {

            Schema::table('users', function (Blueprint $table) {

                $table->dropColumn('category_spending');

            });

        }
    }
};