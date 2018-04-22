<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //权限表
        Schema::create('auth', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid');//父级id
            $table->string('id_list',255);//顶级id至本身id
            $table->unsignedInteger('level');//级别
            $table->unsignedInteger('sort');//排序
            $table->string('name',50);//权限名称
            $table->string('controller',50);//控制器
            $table->string('action',50);//方法
            $table->string('icon',50);//图标
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
        Schema::dropIfExists('auth');
    }
}
