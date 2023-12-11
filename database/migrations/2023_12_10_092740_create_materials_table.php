<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal("stock", 10, 0);
            $table->string('unit');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('material_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_history');
            $table->decimal("stock", 10, 0);
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
        Schema::dropIfExists('materials');
    }
}
