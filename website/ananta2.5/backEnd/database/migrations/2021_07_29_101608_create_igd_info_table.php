<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIgdInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igd_info', function (Blueprint $table) {
            $table->mediumIncrements('igd_info_id');
            $table->string('name', 40);
            $table->string('image', 40);
            $table->mediumInteger('cate_igd_id');
            $table->float('calorie',8,4);
            $table->float('fat',8,4);
            $table->float('protein',8,4);
            $table->float('carbohydrate',8,4);
            $table->float('fiber',8,4);
            $table->mediumInteger('admin_id');
            $table->string('addess', 1000);
            $table->string('addess_img', 1000);
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
        Schema::dropIfExists('igd_info');
    }
}
