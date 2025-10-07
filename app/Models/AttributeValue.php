<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeValue extends Model
{
      use HasFactory;
    protected $fillable = [
        'attributers_id',
         'value',
    ];
    public function singleAttribute()
    {
return $this->hasOne(Attributer::class,'id','attributers_id');
    }
     public function attributer()
    {
        return $this->belongsTo(Attributer::class);
    }
}
