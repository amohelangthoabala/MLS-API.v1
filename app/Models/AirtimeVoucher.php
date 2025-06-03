<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirtimeVoucher extends Model
{
    protected $fillable = ['code', 'denomination', 'status', 'agent_id'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
