<?php

use Illuminate\Database\Seeder;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('subjects')->insert([
             ['subject_name' => 'Toán',
             'subject_code' => 'TOAN',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Lý',
             'subject_code' => 'LY',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Hóa',
             'subject_code' => 'HOA',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Sinh học',
             'subject_code' => 'SH',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Thể dục',
             'subject_code' => 'TD',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Văn',
             'subject_code' => 'VAN',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Sử',
             'subject_code' => 'SU',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Địa',
             'subject_code' => 'DIA',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Tin học',
             'subject_code' => 'TH',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Công nghệ',
             'subject_code' => 'CN',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'Tiếng Anh',
             'subject_code' => 'TA',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['subject_name' => 'GDCD',
             'subject_code' => 'GDCD',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
        ]);
    }
}
