<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempUsers extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_type',
        'token',
    ];
}
