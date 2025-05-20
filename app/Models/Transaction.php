<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['agent_id', 'airtime_voucher_id', 'amount', 'type', 'status'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function voucher()
    {
        return $this->belongsTo(AirtimeVoucher::class, 'airtime_voucher_id');
    }
}
