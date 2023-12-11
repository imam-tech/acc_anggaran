<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('title');
        });
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('image');
            $table->string('title');
        });
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('image');
            $table->string('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_modules');
    }
}
