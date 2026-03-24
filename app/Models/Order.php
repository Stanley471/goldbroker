<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_type',
        'gold_grams',
        'price_per_gram_usd',
        'total_usd',
        'status',
        'reference_number',
        'delivery_method',
        'vault_id',
        'shipping_address',
        'shipping_fee',
        'product_id',
    ];

    protected $casts = [
        'gold_grams' => 'decimal:6',
        'price_per_gram_usd' => 'decimal:6',
        'total_usd' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function vault(): BelongsTo
    {
        return $this->belongsTo(Vault::class);
    }

    public function holdings(): HasMany
    {
        return $this->hasMany(UserHolding::class);
    }
}
