<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashAndBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_and_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('type');
            $table->integer('coa_id');
            $table->decimal('statement_balance', 20, 0)->default(0);
            $table->decimal('balance_in_jurnal', 20, 0)->default(0);
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
        Schema::dropIfExists('cash_and_balances');
    }
}
