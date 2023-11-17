<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoaCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coa_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->string('label');
            $table->enum('flag', ['pt', 'yayasan']);
            $table->integer('sort_number')->nullable();
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
        Schema::dropIfExists('coa_categories');
    }
}
