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

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    $wallet = $user->wallet;
    $goldPrice = $this->goldPriceService->getCurrentPrice();
    $priceChange = $this->goldPriceService->get24hChange();

    return view('dashboard', compact('wallet', 'goldPrice', 'priceChange'));
}

}