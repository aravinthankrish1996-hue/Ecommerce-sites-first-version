<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\ProductAttr;
use Illuminate\Support\Facades\URL;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'product_id',
        'product_attr_id',
        'qty',
    ];
        protected $hidden = [
        'id',
     
    ];
    //      public function products()
    // {
    //     return $this->hasMany(Product::class,'id','product_id')->with('productAttributer');
    // }
        public function product()
    {
        // This links the 'product_id' column in the 'carts' table
        // to the 'id' column in the 'products' table.
        return $this->belongsTo(Product::class, 'product_id');
    }

    // /**
    //  * Define the relationship: A Cart item belongs to one Product Attribute.
    //  */
    public function productAttributer()
    {
        // This links the 'product_attr_id' column in the 'carts' table
        // to the 'id' column in the 'product_attrs' table.
        return $this->belongsTo(ProductAttr::class, 'product_attr_id');
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
