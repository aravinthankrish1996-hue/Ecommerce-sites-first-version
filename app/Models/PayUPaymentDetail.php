<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayUPaymentDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'online_payment_id',
        'mihpayid',
        'mode',
        'status',
        'unmappedstatus',
        'key',
        'txnid',
        'amount',
        'cardCategory',
        'discount',
        'net_amount_debit',
        'addedon',
        'productinfo',
        'firstname',
        'lastname',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'zipcode',
        'email',
        'phone',
        'udf1',
        'udf2',
        'udf3',
        'udf4',
        'udf5',
        'udf6',
        'udf7',
        'udf8',
        'udf9',
        'udf10',
        'hash',
        'field1',
        'field2',
        'field3',
        'field4',
        'field5',
        'field6',
        'field7',
        'field8',
        'field9',
        'payment_source',
        'PG_TYPE',
        'bank_ref_num',
        'bankcode',
        'error',
        'error_Message',
        // Add any other fields that PayU sends back and that you have columns for!
    ];
}