<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufactureProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacture_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->decimal('grand_total', 20, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manufacture_product_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manufacture_product_id');
            $table->integer('semi_finished_material_id');
            $table->string('name')->nullable();
            $table->decimal('price_total', 20, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('manufacture_product_detail_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manufacture_product_detail_id');
            $table->integer('semi_finished_material_item_id');
            $table->integer('material_id');
            $table->string('name');
            $table->string('image');
            $table->string('unit');
            $table->decimal('price_per_unit', 20, 2);
            $table->decimal('dose', 10, 2);
            $table->decimal('price_dose', 20, 2);
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
        Schema::dropIfExists('manufacture_products');
    }
}
