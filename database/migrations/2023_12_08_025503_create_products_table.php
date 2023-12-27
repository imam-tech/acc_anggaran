<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('product_category_id')->nullable();
            $table->string('product_unit_id')->nullable();
            $table->string('name');
            $table->string('sku_code')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_sale')->nullable();
            $table->decimal('unit_sale_price', 20, 0)->nullable();
            $table->integer('sale_account_id')->nullable();
            $table->integer('sale_tax_id')->nullable();
            $table->tinyInteger('is_purchase')->nullable();
            $table->decimal('unit_purchase_price', 20, 0)->nullable();
            $table->integer('purchase_account_id')->nullable();
            $table->integer('purchase_tax_id')->nullable();
            $table->tinyInteger('is_archive')->default(0);
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
        Schema::dropIfExists('products');
    }
}
