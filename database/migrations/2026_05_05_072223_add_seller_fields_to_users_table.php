<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {

        if (!Schema::hasColumn('users', 'shop_name')) {
            $table->string('shop_name')->nullable()->after('name');
        }

        if (!Schema::hasColumn('users', 'contact_number')) {
            $table->string('contact_number')->nullable();
        }

        if (!Schema::hasColumn('users', 'age')) {
            $table->integer('age')->nullable();
        }

        if (!Schema::hasColumn('users', 'valid_id')) {
            $table->string('valid_id')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {

        $table->dropColumn([
            'shop_name',
            'contact_number',
            'age',
            'valid_id',
        ]);
    });
}
};
