<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statlists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('statname')->unique();
            $table->integer('r_id')->unsigned()->index();
            $table->integer('a_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('statlists');
    }
}
