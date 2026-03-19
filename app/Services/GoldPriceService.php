<?php

namespace App\Services;

use App\Models\GoldPrice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GoldPriceService
{
    public function fetchLatestPrice(): array
    {
        $response = Http::withHeaders([
            'x-access-token' => config('services.goldapi.key')
        ])->get('https://www.goldapi.io/api/XAU/USD');

        $data = $response->json();
        $pricePerOz = $data['price'];
        $pricePerGram = $pricePerOz / 31.1035;

        GoldPrice::create([
            'price_per_oz_usd' => $pricePerOz,
            'price_per_gram_usd' => $pricePerGram,
            'currency' => 'USD',
            'source' => 'goldapi.io',
            'fetched_at' => now(),
        ]);

        return [
            'per_oz' => $pricePerOz,
            'per_gram' => $pricePerGram,
        ];
    }
    public function getCurrentPrice(): ?GoldPrice
{
    return Cache::remember('current_gold_price', 900, function () {
        return GoldPrice::latest('fetched_at')->first();
    });
}
}   