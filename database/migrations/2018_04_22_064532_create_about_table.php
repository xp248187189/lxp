<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //博客信息
        Schema::create('about', function (Blueprint $table) {
            $table->increments('id');//id
            $table->string('name','50')->comment('名称');
            $table->string('introduce','255')->comment('简介');
            $table->text('detail')->comment('详情');
            $table->string('label','255')->comment('标签');
            $table->string('img','255')->comment('图片');
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
        Schema::dropIfExists('about');
    }
}
