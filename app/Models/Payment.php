<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'agent_id',
        'mobile_money_provider_id',
        'amount',
        'transaction_reference',
        'status',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function provider()
    {
        return $this->belongsTo(MobileMoneyProvider::class, 'mobile_money_provider_id');
    }
}
