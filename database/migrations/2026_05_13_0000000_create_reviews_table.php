<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // buyer
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // product being reviewed
            $table->unsignedTinyInteger('stars');   // 1–5
            $table->text('body');                   // review text
            $table->unsignedInteger('helpful')->default(0); // helpful count
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};