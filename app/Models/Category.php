<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_category_id', 
        'image',
    ];
    
    protected $table = 'categories';

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
         
            return URL::asset('images/categories/' . $this->image);
        }
       
        return URL::asset('images/placeholder.jpg'); 
    }
    
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    /**
     * Get the subcategories for the category.
     * CORRECTED: Renamed from subCategories to subcategories for consistency.
     */
       public function subcategories()
    {
        // Assuming 'parent_category_id' in the same table links to 'id'
        return $this->hasMany(Category::class, 'parent_category_id', 'id')->with('subcategories');
    }

    // If you also want a parent relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }
    //  public function subcategories()
    // {
      
    //     return $this->hasMany(Category::class, 'parent_category_id')->with('subcategories');
    // }
    
    public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class, 'category_id', 'id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id')->with('productAttributer');
    }
}