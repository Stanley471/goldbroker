<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IraAccount extends Model
{
    //
    protected $fillable = [
        'user_id',
        'account_type',
        'custodian_name',
        'account_number',
        'gold_balance_grams',
        'status',
        'opened_at',
        'tax_year',
    ];
    
    protected $casts = [
        'opened_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
