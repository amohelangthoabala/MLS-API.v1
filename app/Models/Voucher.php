<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'batch_id',
        'voucher_code',
        'denomination',
        'status',
        'assigned_to',
        'sold_at',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(AirtimeBatch::class, 'batch_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
