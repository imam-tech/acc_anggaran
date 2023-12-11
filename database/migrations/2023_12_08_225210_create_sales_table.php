<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('customer_id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('amount_total', 20, 0);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_id');
            $table->integer('product_id');
            $table->decimal('quantity', 10, 0);
            $table->decimal('rate', 20, 0);
            $table->decimal('amount', 20, 0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
