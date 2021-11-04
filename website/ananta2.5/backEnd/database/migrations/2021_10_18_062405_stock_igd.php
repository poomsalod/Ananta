<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockIgd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_igd', function (Blueprint $table) {
            $table->mediumIncrements('stock_igd_id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('igd_info_id');
            $table->float('value',8,4);
            // $table->string('unit', 20);
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
        Schema::dropIfExists('stock_igd');
    }
}
