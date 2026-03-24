<?php

namespace Database\Seeders;

use App\Models\CryptoWallet;
use Illuminate\Database\Seeder;

class CryptoWalletSeeder extends Seeder
{
    public function run(): void
    {
        $wallets = [
            [
                'name' => 'Bitcoin',
                'code' => 'BTC',
                'symbol' => '₿',
                'address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
                'network' => 'Bitcoin',
                'exchange_rate' => 65000, // $65,000 per BTC
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Ethereum',
                'code' => 'ETH',
                'symbol' => 'Ξ',
                'address' => '0x71C7656EC7ab88b098defB751B7401B5f6d8976F',
                'network' => 'ERC-20',
                'exchange_rate' => 3500, // $3,500 per ETH
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tether',
                'code' => 'USDT',
                'symbol' => '₮',
                'address' => '0x71C7656EC7ab88b098defB751B7401B5f6d8976F',
                'network' => 'ERC-20',
                'exchange_rate' => 1, // $1 per USDT
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'USD Coin',
                'code' => 'USDC',
                'symbol' => '$',
                'address' => '0x71C7656EC7ab88b098defB751B7401B5f6d8976F',
                'network' => 'ERC-20',
                'exchange_rate' => 1, // $1 per USDC
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Tether',
                'code' => 'USDT',
                'symbol' => '₮',
                'address' => 'TNP2XwQ8VwJH2f9V2x2J7J5uL2Jh1h9XGn',
                'network' => 'TRC-20',
                'exchange_rate' => 1, // $1 per USDT
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($wallets as $wallet) {
            CryptoWallet::create($wallet);
        }
    }
}
