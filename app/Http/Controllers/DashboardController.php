<?php

namespace App\Http\Controllers;

use App\Services\GoldPriceService;
use App\Services\UserHoldingService;

class DashboardController extends Controller
{
    public function __construct(
        private GoldPriceService $goldPriceService,
        private UserHoldingService $userHoldingService
    ) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        $wallet = $user->wallet;
        $goldPrice = $this->goldPriceService->getCurrentPrice();
        $priceChange = $this->goldPriceService->get24hChange();
        
        // Get holdings summary for the user
        $holdingsSummary = $this->userHoldingService->getHoldingsSummary($user);
        
        // Get grouped holdings for display
        $holdingsGrouped = $this->userHoldingService->getHoldingsGroupedByProduct($user);

        return view('dashboard', compact('wallet', 'goldPrice', 'priceChange', 'holdingsSummary', 'holdingsGrouped'));
    }

}