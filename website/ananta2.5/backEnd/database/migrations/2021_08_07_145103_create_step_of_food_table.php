<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepOfFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_of_food', function (Blueprint $table) {
            $table->mediumIncrements('step_of_food_id');
            $table->mediumInteger('food_id');
            $table->tinyInteger('order');
            $table->string('step', 1200);
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
        Schema::dropIfExists('step_of_food');
    }
}
