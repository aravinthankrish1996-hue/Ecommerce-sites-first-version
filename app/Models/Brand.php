<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\URL;

class Brand extends Model
{
    use  HasFactory;

      protected $fillable = [
        'text',
        'image',
    ];

    protected $appends = ['image_url'];
      public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Assuming your banner images are stored in 'images/banners/'
            return URL::asset('images/Brand/' . $this->image);
        }
        // Fallback placeholder if no image is set
        return URL::asset('images/placeholder.jpg');
    }
    
    
}
