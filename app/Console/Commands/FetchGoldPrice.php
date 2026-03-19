<?php

namespace App\Console\Commands;

use App\Services\GoldPriceService;
use Illuminate\Console\Command;

class FetchGoldPrice extends Command
{
    protected $signature = 'gold:fetch';
    protected $description = 'Fetch latest gold price from API';

    public function handle(GoldPriceService $service)
    {
        $price = $service->fetchLatestPrice();
        $this->info('Gold price fetched: $' . number_format($price['per_gram'], 2) . ' per gram');
    }
}