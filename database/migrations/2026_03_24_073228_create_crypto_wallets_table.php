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
        Schema::create('crypto_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bitcoin, Ethereum, etc.
            $table->string('code'); // BTC, ETH, USDT, USDC
            $table->string('symbol')->nullable(); // ₿, Ξ, ₮, $
            $table->string('address');
            $table->string('network')->nullable(); // ERC-20, TRC-20, etc.
            $table->text('qr_code_data')->nullable();
            $table->decimal('exchange_rate', 20, 10)->default(1); // Rate to USD
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_wallets');
    }
};
