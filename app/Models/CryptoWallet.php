<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoWallet extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'address',
        'network',
        'qr_code_data',
        'exchange_rate',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:10',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name . ($this->network ? ' (' . $this->network . ')' : '');
    }

    public function calculateCryptoAmount(float $usdAmount): float
    {
        if ($this->exchange_rate <= 0) {
            return 0;
        }
        return $usdAmount / $this->exchange_rate;
    }
}
