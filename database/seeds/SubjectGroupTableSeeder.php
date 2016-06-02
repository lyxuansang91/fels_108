<?php

use Illuminate\Database\Seeder;

class SubjectGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('subject_groups')->insert([
             [
                 'subject_id' => 1,
                 'group_id'=> 1,
                 'factor'=> 1,
            ],
            [
                'subject_id' => 1,
                'group_id'=> 2,
                'factor'=> 2,
            ]
        ]);
    }
}
