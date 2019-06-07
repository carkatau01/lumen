<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('user')->insert([
            'username' => 'user_1',
            'password' => Hash::make('test1'),
        ]);

        DB::table('user')->insert([
            'username' => 'user_2',
            'password' => Hash::make('test2'),
        ]);
    }
}
