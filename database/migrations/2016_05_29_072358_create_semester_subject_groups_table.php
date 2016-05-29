<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemesterSubjectGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semester_subject_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semester_id');
            $table->integer('subject_id');
            $table->integer('group_id');
            $table->integer('level_id');
            $table->integer('user_id');
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
        Schema::drop('semester_subject_groups');
    }
}
