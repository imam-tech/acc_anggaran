<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('transaction_uid');
            $table->string('voucher_no');
            $table->string('title');
            $table->timestamp('transaction_date')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('rejected_note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('journal_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('journal_id');
            $table->integer('account_id');
            $table->integer('cashflow_id')->nullable();
            $table->string('description');
            $table->decimal("debit", 20, 2);
            $table->decimal('credit', 20, 2);
            $table->timestamp('transaction_date')->nullable();
            $table->decimal('balance', 20, 2);
            $table->tinyInteger('is_first_balance')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
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
        Schema::dropIfExists('journals');
    }
}
