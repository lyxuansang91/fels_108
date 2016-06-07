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
                'student_code' => 'HS2016001',
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
               'student_code' => 'HS2016002',
               'level_id'=> 1,
               'created_at'=> \Carbon\Carbon::now(),
               'updated_at' => \Carbon\Carbon::now()
           ],
           [
              'name'=> 'Lý Xuân Sang 3',
              'gender'=> 0,
              'birthday'=> '1991-02-04',
              'address'=> 'Hà Nội',
              'student_code' => 'HS2016003',
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
             'student_code' => 'HS2016004',
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
            'student_code' => 'HS2016005',
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
           'student_code' => 'HS2016006',
           'level_id'=> 1,
           'created_at'=> \Carbon\Carbon::now(),
           'updated_at' => \Carbon\Carbon::now()
        ]

        ]);

    }
}
