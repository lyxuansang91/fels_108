<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_word', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('word_id');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->index('user_id');
            $table->index('word_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_word');
    }
}
