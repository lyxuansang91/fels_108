<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('groups')->insert([
             ['group_name' => 'Nâng cao KHTN',
             'group_code' => 'KHTN',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['group_name' => 'Nâng cao XH',
             'group_code' => 'XH',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()],
             ['group_name' => 'Cơ bản',
             'group_code' => 'CB',
             'created_at'=> \Carbon\Carbon::now(),
             'updated_at' => \Carbon\Carbon::now()]
        ]);
    }
}
