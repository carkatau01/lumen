<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('products')->insert([
            'name' => 'product_1',
            'price' => 12000,
            'amount' => 100,
            'created_by' => DB::table('user')->inRandomOrder()->first()->id,
        ]);

        DB::table('products')->insert([
            'name' => 'product_2',
            'price' => 800,
            'amount' => 10,
            'created_by' => DB::table('user')->inRandomOrder()->first()->id,
        ]);

        DB::table('products')->insert([
            'name' => 'product_3',
            'price' => 600,
            'amount' => 20,
            'created_by' => DB::table('user')->inRandomOrder()->first()->id,
        ]);

        DB::table('products')->insert([
            'name' => 'product_4',
            'price' => 200,
            'amount' => 2,
            'created_by' => DB::table('user')->inRandomOrder()->first()->id,
        ]);
    }
}
