<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function creditUSD(User $user, float $amount, string $description): void
    {
        DB::transaction(function () use ($user, $amount, $description) {
            $user->wallet->increment('usd_balance', $amount);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $amount,
                'currency' => 'USD',
                'description' => $description,
            ]);
        });
    }

    public function debitUSD(User $user, float $amount, string $description): void
    {
        if ($user->wallet->usd_balance < $amount) {
            throw new \Exception('Insufficient USD balance');
        }

        DB::transaction(function () use ($user, $amount, $description) {
            $user->wallet->decrement('usd_balance', $amount);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdrawal',
                'amount' => $amount,
                'currency' => 'USD',
                'description' => $description,
            ]);
        });
    }

    public function creditGold(User $user, float $amount, string $description): void
    {
        DB::transaction(function () use ($user, $amount, $description) {
            $user->wallet->increment('gold_balance_grams', $amount);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'buy',
                'amount' => $amount,
                'currency' => 'GOLD',
                'description' => $description,
            ]);
        });
    }

    public function debitGold(User $user, float $amount, string $description): void
    {
        if ($user->wallet->gold_balance_grams < $amount) {
            throw new \Exception('Insufficient gold balance');
        }

        DB::transaction(function () use ($user, $amount, $description) {
            $user->wallet->decrement('gold_balance_grams', $amount);
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'sell',
                'amount' => $amount,
                'currency' => 'GOLD',
                'description' => $description,
            ]);
        });
    }
}