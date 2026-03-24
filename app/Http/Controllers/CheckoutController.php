<?php

namespace App\Http\Controllers;

use App\Models\Vault;
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

        // For other payment methods — redirect to pending page
        return redirect()->route('checkout.pending')->with([
            'payment_method' => $request->payment_method,
            'total' => $total,
        ]);
    }

    public function pending()
    {
        return view('checkout.pending');
    }
}