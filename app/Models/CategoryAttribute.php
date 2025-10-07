<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attributers_id',
        'category_id',
    ];

    protected $table = 'category_attribute'; 

    // A CategoryAttribute record belongs to one Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // A CategoryAttribute record belongs to one Attributer
    public function attributer()
    {
        return $this->belongsTo(Attributer::class, 'attributers_id', 'id')->with('values');
    }
    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attributers_id', 'attributer_id');
    }
}