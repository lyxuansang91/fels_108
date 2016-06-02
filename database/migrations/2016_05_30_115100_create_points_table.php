<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('semester_subject_level_id');
            $table->double('mark_m1', 5, 1)->nullable();
            $table->double('mark_m2', 5, 1)->nullable();
            $table->double('mark_m3', 5, 1)->nullable();
            $table->double('mark_m4', 5, 1)->nullable();
            $table->double('mark_15_1', 5, 1)->nullable();
            $table->double('mark_15_2', 5, 1)->nullable();
            $table->double('mark_15_3', 5, 1)->nullable();
            $table->double('mark_45_1', 5, 1)->nullable();
            $table->double('mark_45_2', 5, 1)->nullable();
            $table->double('mark_last', 5, 1)->nullable();
            $table->double('mark_avg', 5, 1)->nullable();
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
        Schema::drop('points');
    }
}
