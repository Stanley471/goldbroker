<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Transaction;
use App\Models\Order;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'referral_code',
        'referred_by',
        'kyc_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
{
    parent::boot();

    static::creating(function ($user) {
        $user->referral_code = strtoupper(Str::random(8));
    });

    static::created(function ($user) {
        $user->assignRole('user');
        $user->wallet()->create([
            'usd_balance' => 0,
            'gold_balance_grams' => 0,
        ]);
    });
}
public function wallet()
{
    return $this->hasOne(Wallet::class);
}
public function transactions()
{
    return $this->hasMany(Transaction::class);
}
public function orders()
{
    return $this->hasMany(Order::class);
}
}
