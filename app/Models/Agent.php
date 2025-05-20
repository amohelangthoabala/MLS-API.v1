<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['user_id', 'airtime_balance', 'agent_code','balance'];

    public function user()
    {
        // return $this->belongsTo(User::class);
        return $this->belongsTo(\App\Models\User::class);
    }

    public function vouchers()
    {
        return $this->hasMany(AirtimeVoucher::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
