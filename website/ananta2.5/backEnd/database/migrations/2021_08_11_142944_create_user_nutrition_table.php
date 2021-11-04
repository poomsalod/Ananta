<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_nutrition', function (Blueprint $table) {
            $table->mediumIncrements('user_nutrition_id');
            $table->mediumInteger('user_id');
            $table->smallInteger('gender');
            $table->float('weight',8,3);
            $table->float('height',8,3);
            $table->float('activity',8,3);
            $table->float('bmr',8,3);
            $table->float('bmi',8,3);
            $table->float('tdee',8,3);
            $table->smallInteger('analyze_bmi');
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
        Schema::dropIfExists('user_nutrition');
    }
}
