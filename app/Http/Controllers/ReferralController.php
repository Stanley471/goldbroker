<?php

namespace App\Http\Controllers;

use App\Models\Referral;


class ReferralController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $referrals = Referral::where('referrer_id', $user->id)
            ->with('referred')
            ->latest()
            ->get();

        $totalReferrals = $referrals->count();
        $totalGoldEarned = $referrals->where('status', 'credited')->sum('bonus_gold_grams');
        $pendingReferrals = $referrals->where('status', 'pending')->count();

        return view('referral.index', compact(
            'referrals',
            'totalReferrals',
            'totalGoldEarned',
            'pendingReferrals'
        ));
    }
}