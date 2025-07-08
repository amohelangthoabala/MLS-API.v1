<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['merchant_id', 'balance'];
    

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    protected static function booted()
    {
        static::creating(function (Wallet $wallet) {
            if (is_null($wallet->balance) && $wallet->merchant) {
                $wallet->balance = $wallet->merchant->balance ?? 0;
            }
        });
    }


}
