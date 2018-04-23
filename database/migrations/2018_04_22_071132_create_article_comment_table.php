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
            $table->unsignedInteger('article_id')->comment('文章id')->default(0);
            $table->string('article_name',50)->comment('文章标题');
            $table->unsignedInteger('user_id')->comment('用户id')->default(0);
            $table->string('user_account',50)->comment('用户名');
            $table->unsignedInteger('time')->comment('评论时间');
            $table->text('connect')->comment('评论内容');
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
