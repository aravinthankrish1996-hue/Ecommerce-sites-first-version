<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomeBanner extends Model
{
    use HasFactory;


    protected $fillable = [
        'text',
        'link',
        'image',
    ];

    protected $table = 'home_banners';

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Assuming your banner images are stored in 'images/banners/'
            return URL::asset('images/' . $this->image);
        }
        // Fallback placeholder if no image is set
        return URL::asset('images/placeholder.jpg');
    }
}
