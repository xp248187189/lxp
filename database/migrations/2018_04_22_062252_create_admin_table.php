<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //后台管理员表
        Schema::create('admin', function (Blueprint $table) {
            $table->increments('id');//id
            $table->string('account', 50);//管理员登陆账号
            $table->string('name', 50);//管理员姓名
            $table->string('password', 32);//管理员登陆密码
            $table->string('phone', 20);//手机号
            $table->string('email', 50);//手机号
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
            $table->enum('sex', ['男', '女']);//性别
            $table->unsignedInteger('role_id');//角色id
            $table->string('role_name', 50);//角色名称
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
        Schema::dropIfExists('admin');
    }
}
