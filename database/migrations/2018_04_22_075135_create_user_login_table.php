<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户登录
        Schema::create('user_login', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip',50);//登录ip
            $table->unsignedInteger('time');//登录时间
            $table->string('account',50);//登录名
            $table->text('browser');//浏览器信息
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
        Schema::dropIfExists('user_login');
    }
}
