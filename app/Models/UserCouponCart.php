<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Coupon;


class UserCouponCart extends Model
{
      use HasFactory;

         protected $fillable = [
        'user_id',
        'coupon_id',
     
    ];
    
}
