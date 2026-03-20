<?php

namespace App\Services;

use App\Models\IraAccount;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class IraService
{
    public function __construct(private WalletService $walletService) {}

    public function openAccount(User $user, array $data): IraAccount
    {
        return IraAccount::create([
            'user_id' => $user->id,
            'account_type' => $data['account_type'],
            'custodian_name' => $data['custodian_name'] ?? null,
            'account_number' => $data['account_number'] ?? null,
            'gold_balance_grams' => 0,
            'status' => 'active',
            'opened_at' => now(),
            'tax_year' => $data['tax_year'] ?? now()->year,
        ]);
    }

    public function transferToIra(User $user, IraAccount $ira, float $grams): void
    {
        DB::transaction(function () use ($user, $ira, $grams) {
            $this->walletService->debitGold($user, $grams, 'Transfer to IRA #' . $ira->id);
            $ira->increment('gold_balance_grams', $grams);
        });
    }

    public function transferFromIra(User $user, IraAccount $ira, float $grams): void
    {
        if ($ira->gold_balance_grams < $grams) {
            throw new \Exception('Insufficient IRA gold balance');
        }

        DB::transaction(function () use ($user, $ira, $grams) {
            $ira->decrement('gold_balance_grams', $grams);
            $this->walletService->creditGold($user, $grams, 'Transfer from IRA #' . $ira->id);
        });
    }
}