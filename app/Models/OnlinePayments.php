<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'amount',
        'message',
        'order_id',
        'status',
        'url_token',
        'transaction_id',
    ];
}
