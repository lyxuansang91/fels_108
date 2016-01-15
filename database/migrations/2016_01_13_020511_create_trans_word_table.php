<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_words', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id');
            $table->string('trans_word');
            $table->timestamps();

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
        Schema::drop('trans_words');
    }
}
