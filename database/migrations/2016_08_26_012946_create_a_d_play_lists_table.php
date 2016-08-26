<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateADPlayListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adplaylists', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('d_date');
            $table->string('b_time');
            $table->integer('f_id');
            $table->string('number');
            $table->string('len');
            $table->string('content');
            $table->string('belt');
            $table->string('ht_len');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adplaylists');
    }
}
