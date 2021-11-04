<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_rating', function (Blueprint $table) {
            $table->mediumIncrements('food_rating_id');
            $table->mediumInteger('user_id');
            $table->mediumInteger('food_id');
            $table->tinyInteger('rating_score');
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
        Schema::dropIfExists('food_rating');
    }
}
