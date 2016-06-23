<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStudentIdToStudentLevelIdSemesterPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semester_points', function (Blueprint $table) {
            //
            $table->renameColumn('student_id', 'student_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semester_points', function (Blueprint $table) {
            //
        });
    }
}
