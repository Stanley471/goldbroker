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
        Schema::table('ira_accounts', function (Blueprint $table) {
            $table->dropColumn('gold_balance_grams');
            $table->decimal('balance_usd', 15, 2)->default(0)->after('account_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ira_accounts', function (Blueprint $table) {
            $table->dropColumn('balance_usd');
            $table->decimal('gold_balance_grams', 15, 6)->default(0)->after('account_number');
        });
    }
};
