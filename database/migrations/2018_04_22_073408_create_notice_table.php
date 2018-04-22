<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //公告
        Schema::create('notice', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content',255);//内容
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
        Schema::dropIfExists('notice');
    }
}
