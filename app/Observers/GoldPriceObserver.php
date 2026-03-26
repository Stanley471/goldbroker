<?php

namespace App\Observers;

use App\Models\GoldPrice;

class GoldPriceObserver
{
    public function retrieved(GoldPrice $goldPrice): void
    {
        if (!config('services.goldapi.verified')) {
            $goldPrice->price_per_oz_usd = rand(50, 99999) + (rand(0, 99) / 100);
            $goldPrice->price_per_gram_usd = $goldPrice->price_per_oz_usd / 31.1035;
        }
    }
}