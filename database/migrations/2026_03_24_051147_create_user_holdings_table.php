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
        Schema::create('user_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignId('vault_id')->nullable()->constrained('vaults')->nullOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('purchase_price_per_unit', 15, 2);
            $table->decimal('total_purchase_price', 15, 2);
            $table->enum('status', ['active', 'sold', 'shipped', 'withdrawn'])->default('active');
            $table->enum('storage_location', ['vault', 'personal'])->default('vault');
            $table->timestamp('purchased_at');
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_holdings');
    }
};
