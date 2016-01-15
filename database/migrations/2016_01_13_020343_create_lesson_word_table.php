<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_word', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('word_id');
            $table->integer('category_id');
            $table->tinyInteger('result');
            $table->timestamps();

            $table->index('lesson_id');
            $table->index('category_id');
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
        Schema::drop('lesson_word');
    }
}
