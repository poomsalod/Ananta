<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_profile', function (Blueprint $table) {
            $table->mediumIncrements('admin_id');
            $table->mediumInteger('account_id');
            $table->string('f_name',40);
            $table->string('l_name',40);
            $table->string('email',40);
            $table->string('image',40);
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
        Schema::dropIfExists('admin_profile');
    }
}
