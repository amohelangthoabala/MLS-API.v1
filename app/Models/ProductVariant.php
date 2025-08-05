<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'provider', 'name', 'amount',
        'agent_commission_rate', 'platform_commission_rate',
        'source', 'available', 'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function balances()
    {
        return $this->hasMany(MerchantProductVariantBalance::class);
    }
}