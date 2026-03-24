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

    public function deposit(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $wallet = $user->wallet;
        
        return view('wallet.deposit', compact('wallet'));
    }

    public function processDeposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:10', 'max:100000'],
            'payment_method' => ['required', 'in:card,crypto,bank'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $amount = $request->amount;
        $paymentMethod = $request->payment_method;

        // For demonstration, we'll simulate different payment flows
        // In production, integrate with Stripe, Coinbase Commerce, etc.
        
        switch ($paymentMethod) {
            case 'card':
                // In production: redirect to Stripe/PayPal
                // For now, simulate instant deposit
                $this->walletService->creditUSD(
                    $user,
                    $amount,
                    'Credit card deposit'
                );
                return redirect()->route('wallet.index')->with('success', 'Deposit of $' . number_format($amount, 2) . ' completed successfully!');
                
            case 'crypto':
                // In production: generate crypto invoice
                return redirect()->route('wallet.deposit.crypto', ['amount' => $amount]);
                
            case 'bank':
                // In production: show bank transfer details
                return redirect()->route('wallet.deposit.bank', ['amount' => $amount]);
                
            default:
                return back()->with('error', 'Invalid payment method');
        }
    }

    public function depositCrypto(Request $request)
    {
        $amount = $request->get('amount', 0);
        $user = $request->user();
        
        // Get active crypto wallets from database
        $cryptoWallets = \App\Models\CryptoWallet::active()->ordered()->get();
        
        if ($cryptoWallets->isEmpty()) {
            return redirect()->route('wallet.deposit')
                ->with('error', 'Cryptocurrency deposits are temporarily unavailable. Please use another payment method.');
        }
        
        return view('wallet.deposit-crypto', compact('amount', 'cryptoWallets'));
    }

    public function depositBank(Request $request)
    {
        $amount = $request->get('amount', 0);
        $user = $request->user();
        
        // Get active bank accounts from database
        $bankAccounts = \App\Models\BankAccount::active()->ordered()->get();
        
        if ($bankAccounts->isEmpty()) {
            return redirect()->route('wallet.deposit')
                ->with('error', 'Bank transfers are temporarily unavailable. Please use another payment method.');
        }
        
        // Generate unique reference for this deposit
        $reference = 'GV-' . $user->id . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        return view('wallet.deposit-bank', compact('amount', 'bankAccounts', 'reference'));
    }
}