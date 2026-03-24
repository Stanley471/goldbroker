<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use App\Models\Transaction;
use App\Services\CartService;
use App\Services\GoldPriceService;
use App\Services\WalletService;
use App\Services\UserHoldingService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private GoldPriceService $goldPriceService,
        private WalletService $walletService,
        private UserHoldingService $userHoldingService
    ) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->cartService->refreshExpiredPrices($user);
        $cart = $this->cartService->getOrCreateCart($user);
        $cart->load('items.product');

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $vaults = Vault::where('is_active', true)->get();
        $total = $this->cartService->getCartTotal($user);
        $wallet = $user->wallet;

        return view('checkout.index', compact('cart', 'vaults', 'total', 'wallet'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'delivery_method' => ['required', 'in:vault,pickup,ship'],
            'vault_id' => ['required_if:delivery_method,vault,pickup', 'exists:vaults,id'],
            'shipping_address' => ['required_if:delivery_method,ship', 'nullable', 'string'],
            'payment_method' => ['required', 'in:wallet,card,crypto,bank_transfer'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $cart = $this->cartService->getOrCreateCart($user);
        $cart->load('items.product');

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->getCartTotal($user);
        $shippingFee = $request->delivery_method === 'ship' ? $subtotal * 0.005 : 0;
        $total = $subtotal + $shippingFee;

        // Wallet payment
        if ($request->payment_method === 'wallet') {
            if ($user->wallet->usd_balance < $total) {
                return back()->with('error', 'Insufficient wallet balance. Please deposit funds first.');
            }

            try {
                \DB::transaction(function () use ($user, $cart, $request, $subtotal, $shippingFee, $total) {
                    foreach ($cart->items as $item) {
                        $itemTotal = $item->locked_price_per_gram * $item->product->weight_grams * $item->quantity;
                        $itemShippingFee = $request->delivery_method === 'ship' ? $itemTotal * 0.005 : 0;
                        $itemPriceWithShipping = $itemTotal + $itemShippingFee;

                        // Deduct USD from wallet
                        $this->walletService->debitUSD(
                            $user,
                            $itemPriceWithShipping,
                            'Purchase: ' . $item->product->name . ' x' . $item->quantity
                        );

                        // Decrement stock
                        $item->product->decrement('stock', $item->quantity);

                        // Create order
                        $order = \App\Models\Order::create([
                            'user_id' => $user->id,
                            'order_type' => 'buy',
                            'gold_grams' => $item->product->weight_grams * $item->quantity,
                            'price_per_gram_usd' => $item->locked_price_per_gram,
                            'total_usd' => $itemPriceWithShipping,
                            'status' => 'completed',
                            'reference_number' => strtoupper(\Str::random(10)),
                            'delivery_method' => $request->delivery_method,
                            'vault_id' => in_array($request->delivery_method, ['vault', 'pickup']) ? $request->vault_id : null,
                            'shipping_address' => $request->delivery_method === 'ship' ? $request->shipping_address : null,
                            'shipping_fee' => $itemShippingFee,
                            'product_id' => $item->product->id,
                        ]);

                        // Create user holding for this product purchase
                        $this->userHoldingService->createHolding(
                            user: $user,
                            product: $item->product,
                            quantity: $item->quantity,
                            purchasePricePerUnit: $item->locked_price_per_gram * $item->product->weight_grams,
                            order: $order,
                            vaultId: in_array($request->delivery_method, ['vault', 'pickup']) ? $request->vault_id : null,
                            storageLocation: $request->delivery_method === 'ship' ? 'personal' : 'vault'
                        );
                    }

                    // Clear cart
                    $this->cartService->clearCart($user);
                });

                return redirect()->route('dashboard')->with('success', 'Order placed successfully! Your products have been added to your vault.');

            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        // For credit card - process immediately (in production: integrate with Stripe)
        if ($request->payment_method === 'card') {
            try {
                \DB::transaction(function () use ($user, $cart, $request, $subtotal, $shippingFee, $total) {
                    foreach ($cart->items as $item) {
                        $itemTotal = $item->locked_price_per_gram * $item->product->weight_grams * $item->quantity;
                        $itemShippingFee = $request->delivery_method === 'ship' ? $itemTotal * 0.005 : 0;
                        $itemPriceWithShipping = $itemTotal + $itemShippingFee;

                        // Decrement stock
                        $item->product->decrement('stock', $item->quantity);

                        // Create order
                        $order = \App\Models\Order::create([
                            'user_id' => $user->id,
                            'order_type' => 'buy',
                            'gold_grams' => $item->product->weight_grams * $item->quantity,
                            'price_per_gram_usd' => $item->locked_price_per_gram,
                            'total_usd' => $itemPriceWithShipping,
                            'status' => 'completed',
                            'reference_number' => strtoupper(\Str::random(10)),
                            'delivery_method' => $request->delivery_method,
                            'vault_id' => in_array($request->delivery_method, ['vault', 'pickup']) ? $request->vault_id : null,
                            'shipping_address' => $request->delivery_method === 'ship' ? $request->shipping_address : null,
                            'shipping_fee' => $itemShippingFee,
                            'product_id' => $item->product->id,
                        ]);

                        // Create user holding
                        $this->userHoldingService->createHolding(
                            user: $user,
                            product: $item->product,
                            quantity: $item->quantity,
                            purchasePricePerUnit: $item->locked_price_per_gram * $item->product->weight_grams,
                            order: $order,
                            vaultId: in_array($request->delivery_method, ['vault', 'pickup']) ? $request->vault_id : null,
                            storageLocation: $request->delivery_method === 'ship' ? 'personal' : 'vault'
                        );
                    }

                    // Clear cart
                    $this->cartService->clearCart($user);
                });

                return redirect()->route('dashboard')->with('success', 'Order placed successfully! Your products have been added to your vault.');

            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        // For crypto and bank - redirect to payment instructions page
        if (in_array($request->payment_method, ['crypto', 'bank_transfer'])) {
            // Store order details in session for after payment
            session(['pending_order' => [
                'items' => $cart->items->map(fn($item) => [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->locked_price_per_gram * $item->product->weight_grams,
                ])->toArray(),
                'delivery_method' => $request->delivery_method,
                'vault_id' => $request->vault_id,
                'shipping_address' => $request->shipping_address,
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'payment_method' => $request->payment_method,
            ]]);

            if ($request->payment_method === 'crypto') {
                return redirect()->route('checkout.crypto', ['amount' => $total]);
            } else {
                return redirect()->route('checkout.bank', ['amount' => $total]);
            }
        }

        return back()->with('error', 'Invalid payment method.');
    }

    public function pending(Request $request)
    {
        $reference = $request->get('reference');
        $transaction = null;
        
        if ($reference) {
            $transaction = Transaction::where('reference_number', $reference)
                ->where('user_id', auth()->id())
                ->first();
        }
        
        return view('checkout.pending', compact('transaction', 'reference'));
    }

    public function cryptoPayment(Request $request)
    {
        $amount = $request->get('amount', 0);
        $user = auth()->user();
        
        $cryptoWallets = \App\Models\CryptoWallet::active()->ordered()->get();
        
        if ($cryptoWallets->isEmpty()) {
            return redirect()->route('checkout.index')
                ->with('error', 'Cryptocurrency payments are temporarily unavailable. Please use another payment method.');
        }
        
        return view('checkout.crypto', compact('amount', 'cryptoWallets'));
    }

    public function bankPayment(Request $request)
    {
        $amount = $request->get('amount', 0);
        $user = auth()->user();
        
        $bankAccounts = \App\Models\BankAccount::active()->ordered()->get();
        
        if ($bankAccounts->isEmpty()) {
            return redirect()->route('checkout.index')
                ->with('error', 'Bank transfers are temporarily unavailable. Please use another payment method.');
        }
        
        $reference = 'ORD-' . $user->id . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        return view('checkout.bank', compact('amount', 'bankAccounts', 'reference'));
    }

    public function confirmPayment(Request $request)
    {
        $pendingOrder = session('pending_order');
        
        if (!$pendingOrder) {
            return redirect()->route('cart.index')->with('error', 'No pending order found.');
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $paymentMethod = $pendingOrder['payment_method'];

        try {
            // Generate unique reference for this order
            $reference = 'ORD-' . $user->id . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
            // Create orders first (but don't create holdings yet - wait for payment confirmation)
            $orders = [];
            \DB::transaction(function () use ($user, $pendingOrder, $reference, $paymentMethod, &$orders) {
                foreach ($pendingOrder['items'] as $itemData) {
                    $product = \App\Models\Product::find($itemData['product_id']);
                    if (!$product) continue;

                    $itemTotal = $itemData['price'] * $itemData['quantity'];
                    $itemShippingFee = $pendingOrder['delivery_method'] === 'ship' ? $itemTotal * 0.005 : 0;
                    $itemPriceWithShipping = $itemTotal + $itemShippingFee;

                    // Decrement stock (reserve the items)
                    $product->decrement('stock', $itemData['quantity']);

                    // Create order with pending_payment status
                    $order = \App\Models\Order::create([
                        'user_id' => $user->id,
                        'order_type' => 'buy',
                        'gold_grams' => $product->weight_grams * $itemData['quantity'],
                        'price_per_gram_usd' => $itemData['price'] / $product->weight_grams,
                        'total_usd' => $itemPriceWithShipping,
                        'status' => 'pending_payment',
                        'reference_number' => $reference,
                        'delivery_method' => $pendingOrder['delivery_method'],
                        'vault_id' => in_array($pendingOrder['delivery_method'], ['vault', 'pickup']) ? $pendingOrder['vault_id'] : null,
                        'shipping_address' => $pendingOrder['delivery_method'] === 'ship' ? $pendingOrder['shipping_address'] : null,
                        'shipping_fee' => $itemShippingFee,
                        'product_id' => $product->id,
                    ]);
                    
                    $orders[] = $order;

                    // Create transaction record for the purchase (pending status)
                    Transaction::create([
                        'user_id' => $user->id,
                        'type' => 'buy',
                        'amount' => $itemPriceWithShipping,
                        'currency' => 'USD',
                        'description' => 'Purchase: ' . $product->name . ' (awaiting payment confirmation)',
                        'order_id' => $order->id,
                        'status' => 'pending',
                        'reference_number' => $reference,
                        'payment_method' => $paymentMethod,
                    ]);
                }

                // Clear cart
                $this->cartService->clearCart($user);
            });

            // Clear pending order from session
            session()->forget('pending_order');

            // Redirect to pending payment page
            return redirect()->route('checkout.pending', ['reference' => $reference]);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}