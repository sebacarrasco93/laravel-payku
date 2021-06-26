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
            $table->string('id')->index()->unique(); // transaction_id: 1, 2, 3
            $table->string('status')->nullable(); // ['success', '...']
            $table->string('order')->nullable()->unique(); // before: order: trx8956fbcc9e5f4ba62
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('url')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->datetime('notified_at')->nullable();
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
