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
            $table->string('name',50)->comment('链接名称');
            $table->string('url',50)->comment('链接地址');
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
        Schema::dropIfExists('link');
    }
}
