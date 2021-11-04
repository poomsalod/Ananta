<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->mediumIncrements('food_id');
            $table->string('name', 40);
            $table->string('image', 40);
            $table->mediumInteger('cate_food_id');
            $table->float('calorie',8,4);
            $table->float('fat',8,4);
            $table->float('protein',8,4);
            $table->float('carbohydrate',8,4);
            $table->float('fiber',8,4);
            $table->boolean('status');
            $table->string('addess', 1000);
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
        Schema::dropIfExists('food');
    }
}
