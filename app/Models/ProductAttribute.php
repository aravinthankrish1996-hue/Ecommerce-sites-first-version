<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\URL;


class ProductAttribute extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id',
        'category_id',
        'attribute_values_id',



    ];
    //       protected $appends = ['image_url'];

    // public function getImageUrlAttribute()
    // {
    //     if ($this->image) {
    //         // Adjust the path if your attribute images are stored elsewhere
    //         return URL::asset('images/productsAttr/' . $this->image);
    //     }
    //     return URL::asset('images/placeholder.jpg');
    // }
         public function attribute_values()
    {
        return $this->hasOne(AttributeValue::class,'id','attribute_values_id');
    }
}
