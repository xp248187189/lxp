<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('role')->insert(
            [
                'id'=>1,
                'name'=>'副号',
                'auth_ids'=>'38,39,64,66,40,69,71,46,74,76,58,48,49,80,82,50,51,86,88,52,60,53,54,55,56,57,59',
                'sort'=>'99'
            ]
        );
    }
}
