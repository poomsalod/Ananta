<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIgdOfFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igd_of_food', function (Blueprint $table) {
            $table->mediumIncrements('igd_of_food_id');
            $table->mediumInteger('food_id');
            $table->mediumInteger('igd_info_id');
            $table->string('description');
            $table->float('value',8,4);
            $table->string('unit', 20);
            $table->boolean('importance');
            $table->mediumInteger('admin_id');
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
        Schema::dropIfExists('igd_of_food');
    }
}
