<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id',
        'order_type',
        'gold_grams',
        'price_per_gram_usd',
        'total_usd',
        'status',
        'reference_number',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
