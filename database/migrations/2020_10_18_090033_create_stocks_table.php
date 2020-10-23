<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initials');
            $table->string('image')->nullable();
            $table->decimal('current_price', 10, 2)->nullable();
            $table->smallInteger('short_trend')->nullable();
            $table->smallInteger('middle_trend')->nullable();
            $table->integer('current_iv')->nullable();
            $table->dateTime('last_api_update')->nullable();
            $table->decimal('variation', 10, 2)->nullable();

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
        Schema::dropIfExists('stocks');
    }
}
