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
            $table->string('customer_email')->nullable();
            $table->text('billing_address')->nullable();
            $table->date('transaction_date');
            $table->string('transaction_number');
            $table->date('due_date')->nullable();
            $table->decimal('payment_amount_total', 20, 0)->default(0);
            $table->text('message')->nullable();
            $table->decimal('sub_total', 20, 0);
            $table->string('discount_type')->nullable();
            $table->decimal('discount_amount', 20, 0)->default(0);
            $table->decimal('tax_total_amount', 20, 0)->default(0);
            $table->decimal('grand_total', 20, 0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_id');
            $table->integer('product_id');
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price', 20, 0);
            $table->decimal('sub_total', 20, 0);
            $table->integer('tax_id')->nullable();
            $table->integer('tax_percentage')->nullable();
            $table->decimal('tax_amount', 20, 0)->default(0);
            $table->decimal('grand_total', 20, 0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_id');
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
        Schema::dropIfExists('sales');
    }
}
