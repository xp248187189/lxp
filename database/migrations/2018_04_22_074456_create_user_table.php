<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',50);//用户名
            $table->string('sex',5);//性别
            $table->string('head',100);//头像
            $table->unsignedInteger('connectid');//qq登录返回的id
            $table->unsignedInteger('addTime');//加入时间
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
