<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('category_id');
            $table->integer('posting_id');
            $table->string('account_code');
            $table->string('account_number');
            $table->string('account_name');
            $table->string('description')->nullable();
            $table->enum('account_type', ['Debit', "Credit"]);
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('coas');
    }
}
