<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IraAccount extends Model
{
    protected $fillable = [
        'user_id',
        'account_type',
        'custodian_name',
        'account_number',
        'balance_usd',
        'status',
        'opened_at',
        'tax_year',
    ];
    
    protected $casts = [
        'opened_at' => 'datetime',
        'balance_usd' => 'decimal:2',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
