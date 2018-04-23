<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //管理员登录信息
        Schema::create('admin_login', function (Blueprint $table) {
            $table->increments('id');//id
            $table->string('ip',50)->comment('登录ip');
            $table->unsignedInteger('time')->comment('登录时间');
            $table->string('account',50)->comment('登录名');
            $table->text('browser')->comment('浏览器信息');
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
        Schema::dropIfExists('admin_login');
    }
}
