<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdConductNameSemesterIdToConducts extends Migration
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
            $table->integer('user_id');
            $table->integer('semester_id');
            $table->string('conduct_name');
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
            //
        });
    }
}
