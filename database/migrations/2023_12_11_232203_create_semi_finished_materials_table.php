<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemiFinishedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semi_finished_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('', 20, 0);
            $table->decimal('price_total', 20, 0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('semi_finished_material_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semi_finished_material_id');
            $table->integer('material_id');
            $table->decimal('dose', 10, 2);
            $table->decimal('price', 20, 0)->nullable();
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
        Schema::dropIfExists('semi_finished_materials');
    }
}
