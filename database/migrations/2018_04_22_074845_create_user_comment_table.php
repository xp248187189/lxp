<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //留言内容
        Schema::create('user_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');//用户id
            $table->string('user_account',50);//用户名
            $table->unsignedInteger('time');//留言时间
            $table->text('connect');//留言内容
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
        Schema::dropIfExists('user_comment');
    }
}
