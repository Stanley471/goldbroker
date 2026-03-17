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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('order_type', ['buy', 'sell']);
            $table->decimal('gold_grams', 15, 6);
            $table->decimal('price_per_gram_usd', 15, 6);
            $table->decimal('total_usd', 15, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled', 'failed'])->default('pending');
            $table->string('reference_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
