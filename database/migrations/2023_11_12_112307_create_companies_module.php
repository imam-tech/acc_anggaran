<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments("id");
            $table->string('title');
            $table->enum('type', ['pt', 'yayasan']);
            $table->string('voucher_prefix');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('projects', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('company_id');
            $table->string('title');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('project_users', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('project_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('companies_module');
    }
}
