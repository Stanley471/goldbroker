<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Models\UserHolding;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class UserHoldingService
{
    /**
     * Create a new holding for a user when they purchase a product
     */
    public function createHolding(
        User $user,
        Product $product,
        int $quantity,
        float $purchasePricePerUnit,
        ?Order $order = null,
        ?int $vaultId = null,
        string $storageLocation = 'vault'
    ): UserHolding {
        return DB::transaction(function () use ($user, $product, $quantity, $purchasePricePerUnit, $order, $vaultId, $storageLocation) {
            $totalPrice = $purchasePricePerUnit * $quantity;

            return UserHolding::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'order_id' => $order?->id,
                'vault_id' => $vaultId,
                'quantity' => $quantity,
                'purchase_price_per_unit' => $purchasePricePerUnit,
                'total_purchase_price' => $totalPrice,
                'status' => 'active',
                'storage_location' => $storageLocation,
                'purchased_at' => now(),
            ]);
        });
    }

    /**
     * Get all active holdings for a user, grouped by product
     */
    public function getHoldingsGroupedByProduct(User $user): array
    {
        $holdings = $user->activeHoldings()
            ->with('product')
            ->get();

        $grouped = [];

        foreach ($holdings as $holding) {
            $productId = $holding->product_id;
            
            if (!isset($grouped[$productId])) {
                $grouped[$productId] = [
                    'product' => $holding->product,
                    'total_quantity' => 0,
                    'total_purchase_price' => 0,
                    'current_value' => 0,
                    'holdings' => [],
                ];
            }

            $grouped[$productId]['total_quantity'] += $holding->quantity;
            $grouped[$productId]['total_purchase_price'] += $holding->total_purchase_price;
            $grouped[$productId]['current_value'] += $holding->current_value;
            $grouped[$productId]['holdings'][] = $holding;
        }

        // Calculate profit/loss for each group
        foreach ($grouped as &$group) {
            $group['profit_loss'] = $group['current_value'] - $group['total_purchase_price'];
            $group['profit_loss_percent'] = $group['total_purchase_price'] > 0 
                ? (($group['current_value'] - $group['total_purchase_price']) / $group['total_purchase_price']) * 100 
                : 0;
        }

        return $grouped;
    }

    /**
     * Get summary statistics for a user's holdings
     */
    public function getHoldingsSummary(User $user): array
    {
        $holdings = $user->activeHoldings()->with('product')->get();

        $totalPurchaseValue = 0;
        $totalCurrentValue = 0;
        $totalGoldGrams = 0;
        $totalSilverGrams = 0;
        $productTypes = [];

        foreach ($holdings as $holding) {
            $totalPurchaseValue += $holding->total_purchase_price;
            $totalCurrentValue += $holding->current_value;

            if ($holding->product->metal_type === 'gold') {
                $totalGoldGrams += $holding->product->weight_grams * $holding->quantity;
            } else {
                $totalSilverGrams += $holding->product->weight_grams * $holding->quantity;
            }

            $productTypes[$holding->product->name] = ($productTypes[$holding->product->name] ?? 0) + $holding->quantity;
        }

        return [
            'total_holdings' => $holdings->count(),
            'total_products' => array_sum($productTypes),
            'unique_products' => count($productTypes),
            'total_purchase_value' => $totalPurchaseValue,
            'total_current_value' => $totalCurrentValue,
            'profit_loss' => $totalCurrentValue - $totalPurchaseValue,
            'profit_loss_percent' => $totalPurchaseValue > 0 
                ? (($totalCurrentValue - $totalPurchaseValue) / $totalPurchaseValue) * 100 
                : 0,
            'total_gold_grams' => $totalGoldGrams,
            'total_silver_grams' => $totalSilverGrams,
            'product_breakdown' => $productTypes,
        ];
    }

    /**
     * Sell a specific holding
     */
    public function sellHolding(UserHolding $holding, int $quantityToSell): ?Order
    {
        if ($holding->status !== 'active') {
            throw new \Exception('This holding is not available for sale');
        }

        if ($quantityToSell > $holding->quantity) {
            throw new \Exception('Cannot sell more than owned quantity');
        }

        return DB::transaction(function () use ($holding, $quantityToSell) {
            $goldPrice = cache('current_gold_price');
            
            if (!$goldPrice) {
                throw new \Exception('Gold price not available. Please try again.');
            }

            $product = $holding->product;
            $pricePerGram = $goldPrice->price_per_gram_usd * 0.985; // 1.5% spread on sale
            
            if ($product->metal_type !== 'gold') {
                $pricePerGram = ($goldPrice->price_per_gram_usd / 75) * 0.985; // Silver ratio
            }

            $sellPricePerUnit = $pricePerGram * $product->weight_grams;
            $totalSellPrice = $sellPricePerUnit * $quantityToSell;

            // Create sell order
            $order = Order::create([
                'user_id' => $holding->user_id,
                'order_type' => 'sell',
                'gold_grams' => $product->weight_grams * $quantityToSell,
                'price_per_gram_usd' => $pricePerGram,
                'total_usd' => $totalSellPrice,
                'status' => 'completed',
                'reference_number' => strtoupper(\Str::random(10)),
                'product_id' => $product->id,
            ]);

            // Update or delete holding
            if ($quantityToSell === $holding->quantity) {
                $holding->update([
                    'status' => 'sold',
                    'sold_at' => now(),
                    'quantity' => 0,
                ]);
            } else {
                $holding->decrement('quantity', $quantityToSell);
                $holding->update([
                    'total_purchase_price' => $holding->purchase_price_per_unit * ($holding->quantity - $quantityToSell),
                ]);
            }

            return $order;
        });
    }

    /**
     * Transfer holding to another vault or personal storage
     */
    public function transferHolding(
        UserHolding $holding, 
        ?int $vaultId = null, 
        string $storageLocation = 'vault'
    ): UserHolding {
        if ($holding->status !== 'active') {
            throw new \Exception('Cannot transfer non-active holding');
        }

        $holding->update([
            'vault_id' => $vaultId,
            'storage_location' => $storageLocation,
        ]);

        return $holding->fresh();
    }

    /**
     * Get all active holdings for a user, grouped by storage location/vault
     */
    public function getHoldingsGroupedByLocation(User $user): array
    {
        $holdings = $user->activeHoldings()
            ->with(['product', 'vault'])
            ->get();

        $grouped = [
            'vault' => [],
            'personal' => [],
        ];

        foreach ($holdings as $holding) {
            $locationKey = $holding->storage_location === 'personal' ? 'personal' : 'vault';
            
            if ($locationKey === 'vault' && $holding->vault) {
                $vaultId = $holding->vault_id;
                
                if (!isset($grouped['vault'][$vaultId])) {
                    $grouped['vault'][$vaultId] = [
                        'vault' => $holding->vault,
                        'location_name' => $holding->vault->city . ', ' . $holding->vault->country,
                        'total_items' => 0,
                        'total_value' => 0,
                        'holdings' => [],
                    ];
                }
                
                $grouped['vault'][$vaultId]['total_items'] += $holding->quantity;
                $grouped['vault'][$vaultId]['total_value'] += $holding->current_value;
                $grouped['vault'][$vaultId]['holdings'][] = $holding;
            } else {
                // Personal storage
                if (!isset($grouped['personal']['personal'])) {
                    $grouped['personal']['personal'] = [
                        'vault' => null,
                        'location_name' => 'Personal Storage',
                        'total_items' => 0,
                        'total_value' => 0,
                        'holdings' => [],
                    ];
                }
                
                $grouped['personal']['personal']['total_items'] += $holding->quantity;
                $grouped['personal']['personal']['total_value'] += $holding->current_value;
                $grouped['personal']['personal']['holdings'][] = $holding;
            }
        }

        return $grouped;
    }
}
