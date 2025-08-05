<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type'];

    /**
     * Users linked to this merchant (owners, cashiers, etc.)
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'merchant_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Wallet for this merchant
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Balances of product variants
     */
    public function productVariantBalances()
    {
        return $this->hasMany(MerchantProductVariantBalance::class);
    }

    /**
     * Transactions by this merchant
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}