<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\Services\UserHoldingService;

use App\Models\User;
use App\Http\Requests\DepositRequest;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct(
        private WalletService $walletService,
        private UserHoldingService $userHoldingService
    ) {}

    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $wallet = $user->wallet;
        $transactions = $user->transactions()->latest()->get();
        
        // Get holdings grouped by product
        $holdingsGrouped = $this->userHoldingService->getHoldingsGroupedByProduct($user);
        
        // Get holdings summary
        $holdingsSummary = $this->userHoldingService->getHoldingsSummary($user);
        
        return view('wallet.index', compact('wallet', 'transactions', 'holdingsGrouped', 'holdingsSummary'));
    }

    public function deposit(DepositRequest $request)
    {

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