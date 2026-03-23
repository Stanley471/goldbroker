<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'metal_type',
        'weight_grams',
        'brand',
        'description',
        'image',
        'stock',
        'is_active',
        'is_featured',
    ];
    
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    
    public function getCurrentPriceAttribute(): float
    {
        $goldPrice = cache('current_gold_price');
        if (!$goldPrice) return 0;
        
        $pricePerGram = $this->metal_type === 'gold' 
            ? $goldPrice->price_per_gram_usd 
            : ($goldPrice->price_per_gram_usd / 75); // silver ratio approximation
        
        return $pricePerGram * $this->weight_grams * 1.015; // 1.5% markup
    }
}
