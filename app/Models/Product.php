<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;
use App\Models\ProductAttr;


class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'image',
        'item_code',
        'keywords',
        'description',
        'category_id',
        'brand_id',
        'tax_id',



    ];

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

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    // You might also define relationships for category, brand, tax
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
    public function attributer()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id')->with('attribute_values');
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id')->with('attribute_values');
    }
    //     public function productAttributer()
    // {
    //      return $this->hasMany(ProductAttr::class,'product_id','id')->with('image');
    // }
    //     public function productAttributer()
    // {
    //     // FIXED: Eager load the corrected 'images' relationship from ProductAttr
    //     return $this->hasMany(ProductAttr::class, 'product_id', 'id')->with('images','sizes','colors');
    // }
    //         public function productAttributes()
    // {
    //     // FIXED: Eager load the corrected 'images' relationship from ProductAttr
    //     return $this->hasMany(ProductAttr::class, 'product_id', 'id')->with('images','sizes','colors');
    // }
    public function productAttributer()
    {
        return $this->hasMany(ProductAttr::class);
    }
    public function productAttributes()
    {

        return $this->hasMany(ProductAttribute::class);
    }
}
