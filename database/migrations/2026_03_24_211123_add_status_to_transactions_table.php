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
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('completed')->after('description');
            $table->string('reference_number')->nullable()->after('status');
            $table->string('payment_method')->nullable()->after('reference_number');
            $table->timestamp('confirmed_at')->nullable()->after('payment_method');
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete()->after('confirmed_at');
            $table->text('admin_notes')->nullable()->after('confirmed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['status', 'reference_number', 'payment_method', 'confirmed_at', 'confirmed_by', 'admin_notes']);
        });
    }
};
