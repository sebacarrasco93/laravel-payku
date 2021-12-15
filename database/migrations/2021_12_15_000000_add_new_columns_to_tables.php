<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payku_transactions', function (Blueprint $table) {
            $table->string('full_name')->nullable();
        });

        Schema::table('payku_payments', function (Blueprint $table) {
            $table->string('payment_key')->nullable();
            $table->string('transaction_key')->nullable();
            $table->datetime('deposit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payku_payments');
    }
}
