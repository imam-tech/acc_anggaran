<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('supplier_id');
            $table->string('bill_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('amount_total', 20, 0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->integer('product_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->decimal('quantity', 10, 0);
            $table->decimal('price_per_unit', 20,0);
            $table->decimal('amount_total');
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
        Schema::dropIfExists('purchases');
    }
}
