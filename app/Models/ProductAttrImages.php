<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;
use App\Models\ProductAttr;


class ProductAttrImages extends Model
{
     use HasFactory;
     protected $fillable = [
        'product_id',
         'product_attr_id',
        'image',
     



    ];
      protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Adjust the path if your attribute images are stored elsewhere
            return URL::asset('images/productsAttr/' . $this->image);
        }
        return URL::asset('images/placeholder.jpg');
    }
}
