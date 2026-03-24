<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserHolding extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'vault_id',
        'quantity',
        'purchase_price_per_unit',
        'total_purchase_price',
        'status',
        'storage_location',
        'purchased_at',
        'sold_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'sold_at' => 'datetime',
        'purchase_price_per_unit' => 'decimal:2',
        'total_purchase_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function vault(): BelongsTo
    {
        return $this->belongsTo(Vault::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForProduct($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function getCurrentValueAttribute(): float
    {
        return $this->product->current_price * $this->quantity;
    }

    public function getProfitLossAttribute(): float
    {
        return $this->current_value - $this->total_purchase_price;
    }

    public function getProfitLossPercentAttribute(): float
    {
        if ($this->total_purchase_price == 0) return 0;
        return (($this->current_value - $this->total_purchase_price) / $this->total_purchase_price) * 100;
    }
}
