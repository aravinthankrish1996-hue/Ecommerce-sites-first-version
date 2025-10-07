<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\UserAddress;
use App\Models\UserOrdersDetail;
use Illuminate\Support\Facades\URL;

class UserOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total_value',
        'coupon',
        'payment_method',
        'shipping_service',
    ];

    // Cast attributes to proper types
    protected $casts = [
        'total_value' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id', 'id');
    }
    
    public function order_details()
    {
        return $this->hasMany(UserOrdersDetail::class, 'order_id', 'id');
    }
      protected $appends = ['image_url'];
       public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Assuming your banner images are stored in 'images/banners/'
            return URL::asset('images/products/0/' . $this->image);
        }
        // Fallback placeholder if no image is set
        return URL::asset('images/placeholder.jpg');
    }
    
}