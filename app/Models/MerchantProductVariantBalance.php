<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantProductVariantBalance extends Model
{
    use HasFactory;

    protected $fillable = ['merchant_id', 'product_variant_id', 'balance'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}