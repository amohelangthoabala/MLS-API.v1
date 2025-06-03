<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirtimeBatch extends Model
{
   protected $fillable = [
        'mno',
        'denomination',
        'count',
        'purchase_price',
        'status',
        'agent_id',
        'created_by',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class, 'batch_id');
    }
}
