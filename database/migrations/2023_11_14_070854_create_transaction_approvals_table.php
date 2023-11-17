<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_approvals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('transaction_id');
            $table->string('title');
            $table->timestamp("approved_at")->nullable();
            $table->timestamp('rejected_at')->nullable();
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
        Schema::dropIfExists('transaction_approvals');
    }
}
