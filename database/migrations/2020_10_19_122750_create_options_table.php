<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('year');
            $table->string('type');
            $table->date('due_date');
            $table->integer('days_to_maturity');
            $table->decimal('strike', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('spot_price', 10, 2);
            $table->integer('volume')->nullable();
            $table->integer('volatility')->nullable();
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
        Schema::dropIfExists('options');
    }
}
