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
        Schema::create('ira_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('account_type', ['traditional', 'roth', 'sep']);
            $table->string('custodian_name')->nullable();
            $table->string('account_number')->nullable();
            $table->decimal('gold_balance_grams', 15, 6)->default(0);
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamp('opened_at')->nullable();
            $table->integer('tax_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ira_accounts');
    }
};
