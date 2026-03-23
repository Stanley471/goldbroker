<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    //
    protected $fillable = [
        'name',
        'city',
        'country',
        'country_code',
        'address',
        'is_active',
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
