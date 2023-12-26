<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->integer('pay_from');
            $table->integer('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('payment_amount', 20, 0);
            $table->text('memo')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_payment_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_payment_id');
            $table->string('url');
            $table->string('name');
            $table->decimal('size', 20, 0);
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('purchase_payment_journals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_payment_id');
            $table->integer('account_id');
            $table->decimal('debit', 20, 0);
            $table->decimal('credit', 20, 0);
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
        Schema::dropIfExists('purchase_payments');
    }
}
