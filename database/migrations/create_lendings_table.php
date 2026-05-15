<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_lendable')->default(false)->after('status');
        });

        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrower_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('duration_days');
            $table->enum('collateral_type', ['cash', 'item', 'id']);
            $table->text('collateral_description');
            $table->decimal('collateral_value', 10, 2);
            $table->decimal('lending_fee', 10, 2)->default(0);
            $table->text('purpose')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'returned', 'overdue'])
                  ->default('pending');

            $table->timestamp('borrowed_at');
            $table->timestamp('due_date');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('returned_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lendings');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_lendable');
        });
    }
};