<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pay_u_payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('online_payment_id');
            $table->string('mihpayid')->nullable();
            $table->string('mode')->nullable();
            $table->string('unmappedstatus')->nullable();
            $table->string('key')->nullable();
            $table->string('txnid')->nullable();
            $table->string('amount')->nullable();   
            $table->string('discount')->nullable();
            $table->string('net_amount_debit')->nullable();
            $table->string('addedon')->nullable();
            $table->string('productinfo')->nullable();
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('udf1')->nullable();
            $table->string('udf2')->nullable();
            $table->string('udf3')->nullable();
            $table->string('udf4')->nullable();
            $table->string('udf5')->nullable();
            $table->string('udf6')->nullable();
            $table->string('udf7')->nullable();
            $table->string('udf8')->nullable();
            $table->string('udf9')->nullable();
            $table->string('udf10')->nullable();
            $table->longText('hash')->nullable();
            $table->string('field1')->nullable();
            $table->string('field2')->nullable();
            $table->string('field3')->nullable();
            $table->string('field4')->nullable();
            $table->string('field5')->nullable();
            $table->string('field6')->nullable();
            $table->string('field7')->nullable();
            $table->string('field8')->nullable();
            $table->string('field9')->nullable();
            $table->string('payment_source')->nullable();
            $table->string('pa_name')->nullable();
            $table->string('PG_TYPE')->nullable();
            $table->string('bank_ref_num')->nullable();
            $table->string('bankcode')->nullable();
            $table->string('error')->nullable();
            $table->string('error_Message')->nullable();
            $table->timestamps();

            $table->foreign('online_payment_id')->references('id')->on('online_payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_u_payment_details');
    }
};
