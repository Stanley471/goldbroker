<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use Illuminate\Http\Request;
use App\Models\User;

class WalletController extends Controller
{
    public function __construct(private WalletService $walletService) {}

    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $wallet = $user->wallet;
        $transactions = $user->transactions()->latest()->get();
        return view('wallet.index', compact('wallet', 'transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:100000'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $this->walletService->creditUSD(
            $user,
            $request->amount,
            'Manual deposit'
        );

        return back()->with('success', 'Deposit successful');
    }
}