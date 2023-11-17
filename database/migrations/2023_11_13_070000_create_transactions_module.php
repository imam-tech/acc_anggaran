<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('project_id');
            $table->integer('created_by');
            $table->string("transaction_number");
            $table->string('title');
            $table->text('description');
            $table->date('transaction_date')->nullable();
            $table->string('method')->nullable();
            $table->string('bank');
            $table->string('account_holder');
            $table->string('account_number');
            $table->string('current_status');
            $table->decimal('ppn', 20, 2)->default(0);
            $table->decimal('pph', 20, 2)->default(0);
            $table->decimal('dpp', 20, 2)->default(0);
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id');
            $table->string('title');
            $table->string('tax_type')->nullable();
            $table->string('ppn_label')->nullable();
            $table->string('pph_label')->nullable();
            $table->decimal('ppn', 20, 2)->default(0);
            $table->decimal('pph', 20, 2)->default(0);
            $table->decimal('dpp', 20, 2)->default(0);
            $table->decimal('amount_tax', 20, 2)->default(0);
            $table->decimal('input_amount', 20, 2)->default(0);
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->string('attachment');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('transactions_module');
    }
}
