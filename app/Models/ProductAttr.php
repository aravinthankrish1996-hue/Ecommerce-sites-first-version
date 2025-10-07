<?php

namespace App\Models;

use Faker\Core\Color;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;
use App\Models\Size;
use App\Models\Colour;
use App\Models\Product;
use App\Models\ProductAttrImages;

class ProductAttr extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'sku',
        'mrp',
        'price',
        'qty',
        'length',
        'breadth',
        'height',
        'weight',



    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
       public function products()
    {
        return $this->hasMany(Product::class,'id','product_id');
    }

    // public function images()
    // {
    //     return $this->hasMany(Product::class, 'product_id');
    // }
    public function image()
    {
        return $this->hasMany(ProductAttrImages::class, 'product_attr_id', 'id');
    }
    public function images()
    {

        return $this->hasMany(ProductAttrImages::class, 'product_attr_id');
    }
     public function productAttrImages()
    {
        return $this->hasMany(ProductAttrImages::class, 'product_attr_id', 'id');
    }
    public function sizes()
    {

        return $this->hasOne(Size::class, 'id', 'size_id');
    }
    public function colors()
    {

        return $this->hasOne(Colour::class, 'id', 'color_id');
    }
    //       protected $appends = ['image_url'];

    // public function getImageUrlAttribute()
    // {
    //     if ($this->image) {
    //         // Adjust the path if your attribute images are stored elsewhere
    //         return URL::asset('images/productsAttr/' . $this->image);
    //     }
    //     return URL::asset('images/placeholder.jpg');
    // }
}
