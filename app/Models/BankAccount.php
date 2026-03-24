<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'bank_address',
        'routing_number',
        'swift_code',
        'iban',
        'currency',
        'instructions',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('bank_name');
    }

    public function getMaskedAccountNumberAttribute(): string
    {
        $length = strlen($this->account_number);
        if ($length <= 4) {
            return $this->account_number;
        }
        return str_repeat('*', $length - 4) . substr($this->account_number, -4);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->bank_name . ' - ' . $this->currency;
    }
}
