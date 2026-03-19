<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    //
    protected $fillable = [
        'price_per_oz_usd',
        'price_per_gram_usd',
        'currency',
        'source',
        'fetched_at',
    ];
    
    protected $casts = [
        'fetched_at' => 'datetime',
    ];
}
