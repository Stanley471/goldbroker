<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'locked_price_per_gram',
        'price_locked_at',
        'price_expires_at',
    ];
    
    protected $casts = [
        'price_locked_at' => 'datetime',
        'price_expires_at' => 'datetime',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    
    public function getIsExpiredAttribute(): bool
    {
        return $this->price_expires_at->isPast();
    }
    
    public function getSubtotalAttribute(): float
    {
        return $this->locked_price_per_gram * $this->quantity;
    }
}
