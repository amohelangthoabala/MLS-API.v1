<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'reason',
        'reference',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    protected static function booted()
    {
        static::created(function (WalletTransaction $transaction) {
            $wallet = $transaction->wallet;

            if ($transaction->type === 'credit') {
                $wallet->balance += $transaction->amount;
            } elseif ($transaction->type === 'debit') {
                if ($wallet->balance < $transaction->amount) {
                    throw new \Exception('Insufficient balance.');
                }

                $wallet->balance -= $transaction->amount;
            }

            $wallet->save();
        });

        static::deleted(function (WalletTransaction $transaction) {
            $wallet = $transaction->wallet;

            if ($transaction->type === 'credit') {
                $wallet->balance -= $transaction->amount;
            } elseif ($transaction->type === 'debit') {
                $wallet->balance += $transaction->amount;
            }

            $wallet->save();
        });
    }

}
