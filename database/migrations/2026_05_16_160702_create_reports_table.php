<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // reporter (buyer)
        $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('seller_id')->nullable()->constrained('users')->onDelete('cascade');

        $table->string('type'); // product | seller
        $table->text('reason');

        $table->boolean('is_resolved')->default(false);

        $table->timestamps();
    });
}
};
