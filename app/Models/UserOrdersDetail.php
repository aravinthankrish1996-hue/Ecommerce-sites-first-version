<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductAttr;
use App\Models\UserOrder;
use Illuminate\Support\Facades\URL;

class UserOrdersDetail extends Model
{
    use HasFactory;
    
    protected $table = 'user_orders_details';
    
    protected $fillable = [
        'user_id',
        'order_id',
        'product_attr_id',
        'total_value',
        'qty',
    ];

    // Cast attributes to proper types
    protected $casts = [
        'total_value' => 'decimal:2',
        'qty' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Fix: Should be belongsTo, not hasMany since product_attr_id is a foreign key
    public function product_attr()
    {
        return $this->belongsTo(ProductAttr::class, 'product_attr_id', 'id');
    }

    // Optional: Direct relationship to order
    public function order()
    {
        return $this->belongsTo(UserOrder::class, 'order_id', 'id');
    }
    //   protected $appends = ['image_url'];
    //    public function getImageUrlAttribute()
    // {
    //     if ($this->image) {
    //         // Assuming your banner images are stored in 'images/banners/'
    //         return URL::asset('images/products/0/' . $this->image);
    //     }
    //     // Fallback placeholder if no image is set
    //     return URL::asset('images/placeholder.jpg');
    // }
}