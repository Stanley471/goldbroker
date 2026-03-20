<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private WalletService $walletService, private ReferralService $referralService) {}

    public function buy(User $user, float $grams): Order
    {
        $goldPrice = cache('current_gold_price');

        if (!$goldPrice) {
            throw new \Exception('Gold price not available. Please try again.');
        }

        $pricePerGram = $goldPrice->price_per_gram_usd * 1.015; // 1.5% markup
        $totalUsd = $grams * $pricePerGram;

        if ($user->wallet->usd_balance < $totalUsd) {
            throw new \Exception('Insufficient USD balance');
        }

        return DB::transaction(function () use ($user, $grams, $pricePerGram, $totalUsd) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_type' => 'buy',
                'gold_grams' => $grams,
                'price_per_gram_usd' => $pricePerGram,
                'total_usd' => $totalUsd,
                'status' => 'completed',
                'reference_number' => strtoupper(Str::random(10)),
            ]);
        
            $this->walletService->debitUSD($user, $totalUsd, 'Gold purchase - ' . $order->reference_number);
            $this->walletService->creditGold($user, $grams, 'Gold purchase - ' . $order->reference_number);
        
            if ($user->orders()->count() === 1) {
                $this->referralService->processReferralBonus($user);
            }
        
            return $order;
        });
    }

    public function sell(User $user, float $grams): Order
    {
        $goldPrice = cache('current_gold_price');

        if (!$goldPrice) {
            throw new \Exception('Gold price not available. Please try again.');
        }

        $pricePerGram = $goldPrice->price_per_gram_usd * 0.985; // 1.5% spread
        $totalUsd = $grams * $pricePerGram;

        if ($user->wallet->gold_balance_grams < $grams) {
            throw new \Exception('Insufficient gold balance');
        }

        return DB::transaction(function () use ($user, $grams, $pricePerGram, $totalUsd) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_type' => 'sell',
                'gold_grams' => $grams,
                'price_per_gram_usd' => $pricePerGram,
                'total_usd' => $totalUsd,
                'status' => 'completed',
                'reference_number' => strtoupper(Str::random(10)),
            ]);

            $this->walletService->debitGold($user, $grams, 'Gold sale - ' . $order->reference_number);
            $this->walletService->creditUSD($user, $totalUsd, 'Gold sale - ' . $order->reference_number);

            return $order;
        });
    }
}