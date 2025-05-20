<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileMoneyProvider extends Model
{
    protected $fillable = ['name', 'api_url'];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
