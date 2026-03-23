<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CartService
{
    public function getOrCreateCart(User $user): Cart
    {
        return $user->cart ?? $user->cart()->create();
    }

    public function addItem(User $user, Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getOrCreateCart($user);
        $goldPrice = Cache::get('current_gold_price');

        if (!$goldPrice) {
            throw new \Exception('Gold price not available. Please try again.');
        }

        $pricePerGram = $product->metal_type === 'gold'
            ? $goldPrice->price_per_gram_usd * 1.015
            : ($goldPrice->price_per_gram_usd / 75) * 1.015;

        $existing = $cart->items()->where('product_id', $product->id)->first();

        if ($existing) {
            if ($existing->is_expired) {
                $existing->update([
                    'locked_price_per_gram' => $pricePerGram,
                    'price_locked_at' => now(),
                    'price_expires_at' => now()->addMinutes(15),
                    'quantity' => $existing->quantity + $quantity,
                ]);
            } else {
                $existing->increment('quantity', $quantity);
            }
            return $existing->fresh();
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'locked_price_per_gram' => $pricePerGram,
            'price_locked_at' => now(),
            'price_expires_at' => now()->addMinutes(15),
        ]);
    }

    public function removeItem(User $user, int $cartItemId): void
    {
        $cart = $this->getOrCreateCart($user);
        $cart->items()->where('id', $cartItemId)->delete();
    }

    public function clearCart(User $user): void
    {
        $cart = $this->getOrCreateCart($user);
        $cart->items()->delete();
    }

    public function refreshExpiredPrices(User $user): void
    {
        $cart = $this->getOrCreateCart($user);
        $goldPrice = Cache::get('current_gold_price');

        if (!$goldPrice) return;

        foreach ($cart->items as $item) {
            if ($item->is_expired) {
                $pricePerGram = $item->product->metal_type === 'gold'
                    ? $goldPrice->price_per_gram_usd * 1.015
                    : ($goldPrice->price_per_gram_usd / 75) * 1.015;

                $item->update([
                    'locked_price_per_gram' => $pricePerGram,
                    'price_locked_at' => now(),
                    'price_expires_at' => now()->addMinutes(15),
                ]);
            }
        }
    }

    public function getCartTotal(User $user): float
    {
        $cart = $this->getOrCreateCart($user);
        return $cart->items->sum(function ($item) {
            return $item->locked_price_per_gram * $item->product->weight_grams * $item->quantity;
        });
    }
}