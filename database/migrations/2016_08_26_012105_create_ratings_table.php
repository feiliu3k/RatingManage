<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('s_date');
            $table->integer('f_id')->unsigned()->index();
            $table->string('b_time');
            $table->string('e_time');
            $table->integer('rt_id')->unsigned()->index();
            $table->float('a_rating',8,3);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
