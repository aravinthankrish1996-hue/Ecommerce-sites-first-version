<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Colour extends Model
{
     use HasFactory;
    protected $fillable = [
        'text',
         'value',
    ];
      public function productAttributes()
    {
        // Assuming your product variant model is named ProductAttr
        return $this->hasMany(ProductAttr::class);
    }

    
}
