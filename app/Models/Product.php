<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon', 'available'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}