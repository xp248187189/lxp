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
            $table->string('content',255)->comment('内容');
            $table->unsignedTinyInteger('status')->comment('状态')->default(1);
            $table->unsignedInteger('sort')->comment('排序')->default(99);
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
