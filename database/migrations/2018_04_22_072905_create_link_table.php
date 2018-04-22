<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //友情链接
        Schema::create('link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);//链接名称
            $table->string('url',50);//链接地址
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
            $table->unsignedInteger('sort');//排序
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
        Schema::dropIfExists('link');
    }
}
