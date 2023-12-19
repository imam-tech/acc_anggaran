<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('supplier_id');
            $table->string('supplier_email')->nullable();
            $table->text('billing_address')->nullable();
            $table->date('transaction_date');
            $table->string('transaction_number');
            $table->date('due_date')->nullable();
            $table->decimal('payment_amount_total', 20, 0)->default(0);
            $table->text('message')->nullable();
            $table->decimal('sub_total', 20, 0);
            $table->decimal('tax_total_amount', 20, 0)->default(0);
            $table->decimal('grand_total', 20, 0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
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

        Schema::create('purchase_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
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
        Schema::dropIfExists('purchases');
    }
}
