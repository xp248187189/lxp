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
            $table->string('account', 50)->comment('管理员登陆账号');
            $table->string('name', 50)->comment('管理员姓名');
            $table->string('password', 32)->comment('管理员登陆密码');
            $table->string('phone', 20)->comment('手机号');
            $table->string('email', 50)->comment('邮箱');
            $table->unsignedTinyInteger('status')->comment('状态')->default(1);
            $table->enum('sex', ['男', '女'])->comment('性别')->default('男');
            $table->unsignedInteger('role_id')->comment('角色id')->default(0);
            $table->string('role_name', 50)->comment('角色名称');
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
