<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'provider',
        'denominations',
        'is_available',
        'agent_commission',
        'mls_commission',
        'balance',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $casts = [
        'denominations' => 'array',
        'is_available' => 'boolean',
        'agent_commission' => 'float',
        'mls_commission' => 'float',
        'balance' => 'float',
    ];

}
