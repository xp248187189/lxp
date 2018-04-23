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
            $table->unsignedSmallInteger('year')->comment('年');
            $table->unsignedTinyInteger('month')->comment('月');
            $table->unsignedTinyInteger('day')->comment('日');
            $table->unsignedTinyInteger('hour')->comment('时');
            $table->unsignedTinyInteger('minute')->comment('分');
            $table->text('content')->comment('内容');
            $table->unsignedTinyInteger('status')->comment('状态')->default(1);
            $table->unsignedTinyInteger('isHome')->comment('首页显示')->default(0);
            $table->unsignedInteger('time')->comment('时间戳');
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
