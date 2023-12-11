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
            $table->string('category');
            $table->string('brand');
            $table->string('unit');
            $table->string('product_name');
            $table->string('product_image');
            $table->integer('stock');
            $table->decimal('selling_price', 20, 0);
            $table->decimal('purchase_price', 20, 0);
            $table->integer('quantity_alert');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->string('type');
            $table->decimal('stock', 10, 0);
            $table->string('note')->nullable();
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
        Schema::dropIfExists('products');
    }
}
