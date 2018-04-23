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
            $table->string('img',255)->comment('文章主图');
            $table->string('title',50)->comment('文章标题');
            $table->string('outline',255)->comment('文章概要');
            $table->mediumText('content')->comment('文章内容');
            $table->unsignedInteger('category_id')->comment('分类id')->default(0);
            $table->string('category_name',50)->comment('分类名称');
            $table->unsignedTinyInteger('isHome')->comment('是否首页')->default(0);
            $table->unsignedTinyInteger('isRecommend')->comment('是否推荐')->default(0);
            $table->unsignedInteger('sort')->comment('排序')->default(99);
            $table->unsignedTinyInteger('status')->comment('状态')->default(1);
            $table->string('author',50)->comment('作者');
            $table->unsignedInteger('addTime')->comment('添加时间戳');
            $table->unsignedInteger('showNum')->comment('浏览次数')->default(0);
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
