<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fre');
            $table->string('dm');
            $table->string('remark');
            $table->string('xs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fres');
    }
}
