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
        'available',
        'commission_rate'
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
