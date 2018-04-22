<?php

use Illuminate\Database\Seeder;

class AboutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('about')->insert(
        [
            [
                'id' => 1,
                'name' => 'éternel',
                'introduce' => '一枚90后程序员，PHP开发工程师',
                'detail' => '',
                'label' => '四川-成都',
                'img' => '',
            ],
            [
                'id' => 2,
                'name' => '记忆碎片',
                'introduce' => '一个PHP程序员的个人博客',
                'detail' => '',
                'label' => 'http://www.xp.com',
                'img' => '',
            ],
            [
                'id' => 3,
                'name' => '关键字',
                'introduce' => '',
                'detail' => '',
                'label' => '记忆碎片,个人博客,php技术分享,程序员博客',
                'img' => '',
            ],
            [
                'id' => 4,
                'name' => '描述',
                'introduce' => '',
                'detail' => '',
                'label' => '记忆碎片，记录博主学习和成长之路，记录php方面遇到的问题以及解决方法',
                'img' => '',
            ]
        ]
        );
    }
}
