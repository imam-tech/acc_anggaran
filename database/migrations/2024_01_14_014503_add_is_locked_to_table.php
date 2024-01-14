<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLockedToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('role_id')->default(1);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('voucher_prefix')->default(0);
        });

        Schema::table('coas', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('is_active')->default(0);
        });

        Schema::table('cash_and_balances', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('company_id')->default(0);
        });

        Schema::table('taxes', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('is_archive')->default(0);
        });

        Schema::table('product_units', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('is_archive')->default(0);
        });

        Schema::table('payment_methods', function (Blueprint $table) {
            $table->tinyInteger('is_locked')->after('is_archive')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
}
