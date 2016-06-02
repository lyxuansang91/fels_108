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
             ['email' => 'sang.lxuan@gmail.com',
             'password'=> bcrypt('12345678'),
             'role' => 1,
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()]
        ]);
    }
}
