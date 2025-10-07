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
        Schema::table('pay_u_payment_details', function (Blueprint $table) {
            $table->string('status')->nullable()->after('mode');
            $table->string('cardCategory')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pay_u_payment_details', function (Blueprint $table) {
            //
        });
    }
};
