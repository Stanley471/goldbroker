<?php

namespace App\Http\Controllers;

use App\Services\GoldPriceService;

class DashboardController extends Controller
{
    public function __construct(private GoldPriceService $goldPriceService) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $wallet = $user->wallet;
        $goldPrice = $this->goldPriceService->getCurrentPrice();

        return view('dashboard', compact('wallet', 'goldPrice'));
    }
}