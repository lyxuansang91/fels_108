<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
             ['name'=> "Nguyễn Thị Thu Trang",
             'email' => 'thutrang2393@gmail.com',
             'password'=> bcrypt('12345678'),
             'avatar' => '/images/avatar/default.png',
             'role' => 1,
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()]
        ]);
    }
}
