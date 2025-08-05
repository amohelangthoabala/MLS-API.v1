<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MerchantUser extends Pivot
{
    protected $table = 'merchant_user';

    protected $fillable = ['user_id', 'merchant_id', 'role'];
}