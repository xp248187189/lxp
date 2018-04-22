<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //分类管理
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);//分类名称
            $table->unsignedInteger('sort');//排序
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
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
        Schema::dropIfExists('category');
    }
}
