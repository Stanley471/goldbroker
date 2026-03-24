<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->cartService->refreshExpiredPrices($user);
        $cart = $this->cartService->getOrCreateCart($user);
        $cart->load('items.product');
        $total = $this->cartService->getCartTotal($user);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $product = Product::findOrFail($request->product_id);

        try {
            $this->cartService->addItem($user, $product, $request->quantity);
            return back()->with('cart_success', $product->name);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(Request $request, $cartItemId)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->cartService->removeItem($user, $cartItemId);
        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $this->cartService->clearCart($user);
        return back()->with('success', 'Cart cleared.');
    }
}