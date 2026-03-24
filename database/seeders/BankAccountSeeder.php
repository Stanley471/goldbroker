<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'account_name' => 'GoldVault Inc.',
                'account_number' => '1234567890',
                'bank_name' => 'JPMorgan Chase Bank',
                'bank_address' => '270 Park Avenue, New York, NY 10017, USA',
                'routing_number' => '021000021',
                'swift_code' => 'CHASUS33',
                'iban' => null,
                'currency' => 'USD',
                'instructions' => 'For wire transfers, please include your reference number. Domestic wires typically clear within 1-2 business days.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'account_name' => 'GoldVault Inc.',
                'account_number' => 'GB29NWBK60161331926819',
                'bank_name' => 'NatWest Bank',
                'bank_address' => '250 Bishopsgate, London EC2M 4AA, UK',
                'routing_number' => null,
                'swift_code' => 'NWBKGB2L',
                'iban' => 'GB29NWBK60161331926819',
                'currency' => 'GBP',
                'instructions' => 'For SEPA transfers, please use the IBAN. Transfers typically clear within 1-2 business days.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'account_name' => 'GoldVault GmbH',
                'account_number' => 'DE89370400440532013000',
                'bank_name' => 'Deutsche Bank',
                'bank_address' => 'Taunusanlage 12, 60325 Frankfurt am Main, Germany',
                'routing_number' => null,
                'swift_code' => 'DEUTDEFF',
                'iban' => 'DE89370400440532013000',
                'currency' => 'EUR',
                'instructions' => 'For SEPA transfers within Europe. Transfers typically clear within 1 business day.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($accounts as $account) {
            BankAccount::create($account);
        }
    }
}
