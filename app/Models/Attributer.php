<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attributer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
    ];
    protected $table = 'attributers'; 
    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attributers_id', 'id');
    }
   public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class, 'attributers_id', 'id');
    }


}
