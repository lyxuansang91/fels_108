<?php

use Illuminate\Database\Seeder;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $teacher = \App\Models\Teacher::create([
            'teacher_name' => 'Hoàng Anh Đức',
            'teacher_code' => 'GV0001',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 2,
            'subject_id'=> 1,
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('levels')->insert([
             ['level_name' => 'A',
             'grade_id'=> 3,
             'group_id'=> 1,
             'teacher_id'=> 1,
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()]
        ]);
    }
}
