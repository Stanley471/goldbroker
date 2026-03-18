<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
    protected $fillable = [
        'user_id',
        'usd_balance',
        'gold_balance_grams',
    ];
}
