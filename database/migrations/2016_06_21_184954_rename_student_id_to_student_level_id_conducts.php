<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameStudentIdToStudentLevelIdConducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conducts', function (Blueprint $table) {
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
        Schema::table('conducts', function (Blueprint $table) {

            $table->renameColumn('student_level_id', 'student_id');
        });
    }
}
