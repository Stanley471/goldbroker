<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\Services\UserHoldingService;

use App\Models\User;
use App\Models\Transaction;
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
        
        // Get selected method from query parameter (e.g., ?method=crypto)
        $selectedMethod = $request->get('method', 'card');
        
        // Validate method
        if (!in_array($selectedMethod, ['card', 'crypto', 'bank'])) {
            $selectedMethod = 'card';
        }
        
        return view('wallet.deposit', compact('wallet', 'selectedMethod'));
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

        switch ($paymentMethod) {
            case 'card':
                // Credit card deposits are instant
                $this->walletService->creditUSD(
                    $user,
                    $amount,
                    'Credit card deposit'
                );
                return redirect()->route('wallet.index')->with('success', 'Deposit of $' . number_format($amount, 2) . ' completed successfully!');
                
            case 'crypto':
                // Check if this is a confirmation that crypto was sent
                if ($request->has('confirm_payment')) {
                    // Generate unique reference
                    $reference = 'DEP-' . $user->id . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
                    
                    // Create pending transaction
                    Transaction::create([
                        'user_id' => $user->id,
                        'type' => 'deposit',
                        'amount' => $amount,
                        'currency' => 'USD',
                        'description' => 'Cryptocurrency deposit (awaiting confirmation)',
                        'status' => 'pending',
                        'reference_number' => $reference,
                        'payment_method' => 'crypto',
                    ]);
                    
                    return redirect()->route('wallet.deposit.pending', ['reference' => $reference]);
                }
                
                // Show crypto payment page
                return redirect()->route('wallet.deposit.crypto', ['amount' => $amount]);
                
            case 'bank':
                // Check if this is a confirmation that bank transfer was sent
                if ($request->has('confirm_payment')) {
                    // Generate unique reference
                    $reference = 'DEP-' . $user->id . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
                    
                    // Create pending transaction
                    Transaction::create([
                        'user_id' => $user->id,
                        'type' => 'deposit',
                        'amount' => $amount,
                        'currency' => 'USD',
                        'description' => 'Bank transfer deposit (awaiting confirmation)',
                        'status' => 'pending',
                        'reference_number' => $reference,
                        'payment_method' => 'bank_transfer',
                    ]);
                    
                    return redirect()->route('wallet.deposit.pending', ['reference' => $reference]);
                }
                
                // Show bank transfer page
                return redirect()->route('wallet.deposit.bank', ['amount' => $amount]);
                
            default:
                return back()->with('error', 'Invalid payment method');
        }
    }

    public function pendingDeposit(Request $request)
    {
        $reference = $request->get('reference');
        $transaction = Transaction::where('reference_number', $reference)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        return view('wallet.deposit-pending', compact('transaction'));
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