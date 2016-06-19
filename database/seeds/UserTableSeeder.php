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
        // DB::table('users')->insert([
        //      ['email' => 'duc.ha@gmail.com',
        //      'password'=> bcrypt('12345678'),
        //      'role' => 3,
        //      'created_at'=> \Carbon\Carbon::now(),
        //      'updated_at' => \Carbon\Carbon::now()]
        // , [
        //     'email' => 'ly123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'hoa123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'sinh123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'theduc123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'van123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'su123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'dia123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'congnghe123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'tienganh123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'gdcd123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ], [
        //     'email' => 'tinhoc123@gmail.com',
        //     'password'=> bcrypt('12345678'),
        //     'role' => 3,
        //     'created_at'=> \Carbon\Carbon::now(),
        //     'updated_at' => \Carbon\Carbon::now()
        // ]]);
    }
}
