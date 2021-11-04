<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FoodRecommended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_recommended', function (Blueprint $table) {
            $table->mediumIncrements('food_recommended_id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('food_id');
            $table->float('score_nutrition',8,4);
            $table->float('score_sum',8,4);
            $table->mediumInteger('igd_matching');
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
        Schema::dropIfExists('food_recommended');
    }
}
