<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionItemCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_item_coas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->integer('transaction_item_id');
            $table->integer('account_id');
            $table->integer('cashflow_id')->nullable();
            $table->decimal('debit', 20, 2);
            $table->decimal('credit', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_item_coas');
    }
}
