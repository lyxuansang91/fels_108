<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('students')->insert([
             [
                'name'=> 'Lý Xuân Sang',
                'gender'=> 0,
                'birthday'=> '1991-02-04',
                'address'=> 'Hà Nội',
                'phone'=> '09999999',
                'level_id'=> 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
               'name'=> 'Lý Xuân Sang 2',
               'gender'=> 0,
               'birthday'=> '1991-02-04',
               'address'=> 'Hà Nội',
               'phone'=> '09999999',
               'level_id'=> 1,
               'created_at'=> \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now()
           ],
           [
              'name'=> 'Lý Xuân Sang 3',
              'gender'=> 0,
              'birthday'=> '1991-02-04',
              'address'=> 'Hà Nội',
              'phone'=> '09999999',
              'level_id'=> 1,
              'created_at'=> \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now()
          ],
          [
             'name'=> 'Lý Xuân Sang 4',
             'gender'=> 0,
             'birthday'=> '1991-02-04',
             'address'=> 'Hà Nội',
             'phone'=> '09999999',
             'level_id'=> 1,
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()
         ]
         , [
            'name'=> 'Lý Xuân Sang 5',
            'gender'=> 0,
            'birthday'=> '1991-02-04',
            'address'=> 'Hà Nội',
            'phone'=> '09999999',
            'level_id'=> 1,
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]
        , [
           'name'=> 'Lý Xuân Sang 6',
           'gender'=> 0,
           'birthday'=> '1991-02-04',
           'address'=> 'Hà Nội',
           'phone'=> '09999999',
           'level_id'=> 1,
           'created_at'=> \Carbon\Carbon::now(),
           'updated_at' => \Carbon\Carbon::now()
        ]

        ]);

        DB::table('semester_subject_levels')->insert([
            'semester_id' => 1,
            'subject_id' => 1,
            'level_id' => 1,
            'teacher_id'=> 1,
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        $students = \App\Models\Student::where('level_id', 1)->get();
        foreach($students as $student) {
            $point = new \App\Models\Point();
            $point->semester_subject_level_id = 1;
            $point->student_id = $student->id;
            $point->save();
        }
    }
}
