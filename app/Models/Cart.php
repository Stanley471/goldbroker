<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = [
        'user_id',
    ];
    
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getTotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->locked_price_per_gram * $item->quantity;
        });
    }
}
