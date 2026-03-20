<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    public function __construct(private WalletService $walletService) {}

    public function processReferralBonus(User $newUser): void
    {
        if (!$newUser->referred_by) return;

        $alreadyProcessed = Referral::where('referred_id', $newUser->id)->exists();
        if ($alreadyProcessed) return;

        $referrer = User::find($newUser->referred_by);
        if (!$referrer) return;

        $bonusGrams = config('referral.bonus_grams', 0.1);

        DB::transaction(function () use ($referrer, $newUser, $bonusGrams) {
            $this->walletService->creditGold($referrer, $bonusGrams, 'Referral bonus');
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $newUser->id,
                'bonus_gold_grams' => $bonusGrams,
                'status' => 'credited',
                'credited_at' => now(),
            ]);
        });
    }
}