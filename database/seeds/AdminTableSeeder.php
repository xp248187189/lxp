<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('admin')->insert(
            [
                [
                    'id'=>1,
                    'account'=>'xp248187189',
                    'name'=>'éternel',
                    'password'=>'1453c23ab2ccd5a99672b1fae32dfb78',
                    'phone'=>'15882180558',
                    'email'=>'248187189@qq.com',
                    'status'=>1,
                    'sex'=>'男',
                    'role_id'=>'0',
                    'role_name'=>'超级管理员'
                ],
                [
                    'id'=>2,
                    'account'=>'test',
                    'name'=>'测试账号',
                    'password'=>'47ec2dd791e31e2ef2076caf64ed9b3d',
                    'phone'=>'12345678912',
                    'email'=>'123456789@qq.com',
                    'status'=>1,
                    'sex'=>'男',
                    'role_id'=>'1',
                    'role_name'=>''
                ],
            ]
        );
    }
}
