<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //文章评论
        Schema::create('article_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id');//文章id
            $table->string('article_name',50);//文章标题
            $table->unsignedInteger('user_id');//用户id
            $table->string('user_account',50);//用户名
            $table->unsignedInteger('time');//评论时间
            $table->text('connect');//评论内容
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
        Schema::dropIfExists('article_comment');
    }
}
