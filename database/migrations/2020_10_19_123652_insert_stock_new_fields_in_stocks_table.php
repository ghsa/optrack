<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertStockNewFieldsInStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('current_price', 10, 2)->nullable();
            $table->smallInteger('short_trend')->nullable();
            $table->smallInteger('middle_trend')->nullable();
            $table->integer('current_iv')->nullable();
            $table->dateTime('last_ip_update')->nullable();
            $table->decimal('variation', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            //
        });
    }
}
