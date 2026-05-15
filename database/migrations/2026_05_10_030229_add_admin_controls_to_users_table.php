<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // SELLER APPROVAL
            if (!Schema::hasColumn('users', 'is_approved')) {

                $table->boolean('is_approved')
                      ->default(false);

            }

            // BLOCK SYSTEM
            if (!Schema::hasColumn('users', 'is_blocked')) {

                $table->boolean('is_blocked')
                      ->default(false);

            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // DROP ONLY IF EXISTS

            if (Schema::hasColumn('users', 'is_approved')) {
                $table->dropColumn('is_approved');
            }

            if (Schema::hasColumn('users', 'is_blocked')) {
                $table->dropColumn('is_blocked');
            }

            if (Schema::hasColumn('users', 'shop_name')) {
                $table->dropColumn('shop_name');
            }

            if (Schema::hasColumn('users', 'seller_name')) {
                $table->dropColumn('seller_name');
            }

            if (Schema::hasColumn('users', 'contact_number')) {
                $table->dropColumn('contact_number');
            }

            if (Schema::hasColumn('users', 'valid_id')) {
                $table->dropColumn('valid_id');
            }

        });
    }
};