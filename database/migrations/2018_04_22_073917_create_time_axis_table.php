<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeAxisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //时间轴
        Schema::create('time_axis', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('year');//年
            $table->unsignedTinyInteger('month');//月
            $table->unsignedTinyInteger('day');//日
            $table->unsignedTinyInteger('hour');//时
            $table->unsignedTinyInteger('minute');//分
            $table->text('content');//内容
            $table->unsignedTinyInteger('status');//状态 0/1[禁用/启用]
            $table->unsignedTinyInteger('isHome');//首页显示
            $table->unsignedInteger('time');//时间戳
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
        Schema::dropIfExists('time_axis');
    }
}
