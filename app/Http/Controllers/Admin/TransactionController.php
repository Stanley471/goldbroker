<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\WalletService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {}

    public function index()
    {
        $pendingTransactions = Transaction::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'pending_page');

        $completedTransactions = Transaction::with(['user', 'confirmer'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(10, ['*'], 'completed_page');

        $failedTransactions = Transaction::with(['user', 'confirmer'])
            ->whereIn('status', ['failed', 'cancelled'])
            ->latest()
            ->paginate(10, ['*'], 'failed_page');

        $stats = [
            'pending' => Transaction::where('status', 'pending')->count(),
            'completed' => Transaction::where('status', 'completed')->count(),
            'failed' => Transaction::whereIn('status', ['failed', 'cancelled'])->count(),
            'total' => Transaction::count(),
            'pending_amount' => Transaction::where('status', 'pending')->where('type', 'deposit')->sum('amount'),
        ];

        return view('admin.transactions.index', compact(
            'pendingTransactions', 
            'completedTransactions', 
            'failedTransactions', 
            'stats'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'confirmer', 'order']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function confirm(Request $request, Transaction $transaction)
    {
        if (!$transaction->isPending()) {
            return redirect()->back()->with('error', 'This transaction has already been processed.');
        }

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            \DB::transaction(function () use ($transaction, $validated) {
                // Update transaction status
                $transaction->update([
                    'status' => 'completed',
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'admin_notes' => $validated['admin_notes'] ?? null,
                ]);

                // If it's a deposit, credit the user's wallet
                if ($transaction->type === 'deposit') {
                    $this->walletService->creditUSD(
                        $transaction->user,
                        $transaction->amount,
                        'Deposit confirmed: ' . $transaction->reference_number
                    );
                }

                // If it's a buy order transaction, update the order status
                if ($transaction->type === 'buy' && $transaction->order) {
                    $transaction->order->update(['status' => 'completed']);
                }
            });

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction confirmed successfully. User wallet has been credited.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error confirming transaction: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if (!$transaction->isPending()) {
            return redirect()->back()->with('error', 'This transaction has already been processed.');
        }

        $validated = $request->validate([
            'admin_notes' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'admin_notes.required' => 'Please provide a reason for rejection.',
            'admin_notes.min' => 'The rejection reason must be at least 10 characters.',
        ]);

        try {
            \DB::transaction(function () use ($transaction, $validated) {
                // Update transaction status
                $transaction->update([
                    'status' => 'failed',
                    'confirmed_at' => now(),
                    'confirmed_by' => auth()->id(),
                    'admin_notes' => $validated['admin_notes'],
                ]);

                // If it's a buy order transaction, update the order status and restore stock
                if ($transaction->type === 'buy' && $transaction->order) {
                    $transaction->order->update(['status' => 'cancelled']);
                    
                    // Restore product stock
                    $product = $transaction->order->product;
                    if ($product) {
                        $product->increment('stock', $transaction->order->gold_grams / $product->weight_grams);
                    }
                }
            });

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction rejected successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error rejecting transaction: ' . $e->getMessage());
        }
    }
}
