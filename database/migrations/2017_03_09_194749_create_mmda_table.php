<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMmdaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mmda', function (Blueprint $table) {
            $table->increments('id');
            $table->string('road1');
            $table->string('road2');
            $table->string('way');
            $table->string('description');
            $table->string('pubDate');
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
        Schema::drop('mmda');
    }
}
