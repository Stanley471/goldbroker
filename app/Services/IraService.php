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
            'balance_usd' => 0,
            'status' => 'active',
            'opened_at' => now(),
            'tax_year' => $data['tax_year'] ?? now()->year,
        ]);
    }

    public function transferToIra(User $user, IraAccount $ira, float $amount): void
    {
        if ($user->wallet->usd_balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        DB::transaction(function () use ($user, $ira, $amount) {
            $this->walletService->debitUSD(
                $user, 
                $amount, 
                'Transfer to IRA #' . $ira->id
            );
            $ira->increment('balance_usd', $amount);
        });
    }

    public function transferFromIra(User $user, IraAccount $ira, float $amount): void
    {
        if ($ira->balance_usd < $amount) {
            throw new \Exception('Insufficient IRA balance');
        }

        DB::transaction(function () use ($user, $ira, $amount) {
            $ira->decrement('balance_usd', $amount);
            $this->walletService->creditUSD(
                $user, 
                $amount, 
                'Transfer from IRA #' . $ira->id
            );
        });
    }
}
