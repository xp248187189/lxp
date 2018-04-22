<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //笔记
        Schema::create('note', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255);//标题
            $table->string('url',255);//url地址
            $table->string('account',255);//账号
            $table->string('password',255);//密码
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
        Schema::dropIfExists('note');
    }
}
