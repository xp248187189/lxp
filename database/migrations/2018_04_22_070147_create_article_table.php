<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //文章管理
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img',255);//文章主图
            $table->string('title',50);//文章标题
            $table->string('outline',255);//文章概要
            $table->mediumText('content');//文章内容
            $table->unsignedInteger('category_id');//分类id
            $table->string('category_name',50);//分类名称
            $table->unsignedTinyInteger('isHome');//是否首页
            $table->unsignedTinyInteger('isRecommend');//是否推荐
            $table->unsignedInteger('sort');//排序
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
            $table->string('author',50);//作者
            $table->unsignedInteger('addTime');//添加时间戳
            $table->unsignedInteger('showNum');//浏览次数
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
        Schema::dropIfExists('article');
    }
}
