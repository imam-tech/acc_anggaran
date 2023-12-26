<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_id');
            $table->integer('deposit_to');
            $table->integer('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('payment_amount', 20, 0);
            $table->text('memo')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_payment_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_payment_id');
            $table->string('url');
            $table->string('name');
            $table->decimal('size', 20, 0);
            $table->string('type');
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
        Schema::dropIfExists('sales_payments');
    }
}
