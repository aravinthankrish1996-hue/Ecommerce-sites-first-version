<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
    ];

      public function productAttributes()
    {
        // Assuming your product variant model is named ProductAttr
        return $this->hasMany(ProductAttr::class);
    }
}
