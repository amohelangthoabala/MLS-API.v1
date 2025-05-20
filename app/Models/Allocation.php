<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    protected $fillable = ['agent_id', 'denomination', 'quantity'];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
