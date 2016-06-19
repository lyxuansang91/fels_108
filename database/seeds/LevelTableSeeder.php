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
        \App\Models\Teacher::insert([[
            'teacher_name' => 'Hoàng Anh Đức',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 2,
            'subject_id'=> 1,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Đặng Trần Chiến',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 3,
            'subject_id'=> 2,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Nguyễn Thị Thu',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 4,
            'subject_id'=> 3,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Vũ Thị Hiên',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 5,
            'subject_id'=> 4,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Bùi Huỳnh Thân',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 6,
            'subject_id'=> 5,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Đỗ Tú Oanh',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 7,
            'subject_id'=> 6,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Đỗ Thị Thu Quyên',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 8,
            'subject_id'=> 7,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Nguyễn Mạnh Hà',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 9,
            'subject_id'=> 8,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Đỗ Thị Hằng',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 10,
            'subject_id'=> 10,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Lê Thị Lan Hương',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 11,
            'subject_id'=> 11,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Ninh Hạnh Quyên',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 1,
            'user_id'=> 12,
            'subject_id'=> 12,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ], [
            'teacher_name' => 'Vũ Văn Thỏa',
            'address' => 'Hà Nội',
            'phone' => '000000000',
            'gender' => 0,
            'user_id'=> 13,
            'subject_id'=> 9,
            'birthday' => \Carbon\Carbon::now(),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]]);
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
