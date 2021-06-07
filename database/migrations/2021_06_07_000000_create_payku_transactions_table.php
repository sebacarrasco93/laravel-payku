<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaykuTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payku_transactions', function (Blueprint $table) {
            $table->string('id')->index()->unique()->nullable(); // transaction_id
            $table->string('status')->nullable(); // ['success', '...']
            $table->string('order_id')->unique(); // order
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->unsignedInteger('amount');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payku_transactions');
    }
}
