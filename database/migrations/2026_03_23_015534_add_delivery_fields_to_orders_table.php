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
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->enum('delivery_method', ['vault', 'pickup', 'ship'])->nullable();
$table->foreignId('vault_id')->nullable()->constrained('vaults')->nullOnDelete();
$table->text('shipping_address')->nullable();
$table->decimal('shipping_fee', 15, 2)->default(0);
$table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn(['delivery_method', 'vault_id', 'shipping_address', 'shipping_fee', 'product_id']);
        });
    }
};
