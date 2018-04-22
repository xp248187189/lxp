<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('category')->insert(
            [
                ['id'=>1,'name'=>'PHP','sort'=>99,'status'=>1],
                ['id'=>2,'name'=>'JavaScript','sort'=>99,'status'=>1],
                ['id'=>3,'name'=>'HTML','sort'=>99,'status'=>1],
                ['id'=>4,'name'=>'Linux','sort'=>99,'status'=>1],
                ['id'=>5,'name'=>'杂谈','sort'=>99,'status'=>1],
            ]
        );
    }
}
