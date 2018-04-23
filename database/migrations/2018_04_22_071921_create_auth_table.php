<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //权限表
        Schema::create('auth', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->comment('父级id')->default(0);
            $table->string('id_list',255)->comment('顶级id至本身id');
            $table->unsignedInteger('level')->comment('级别')->default(0);
            $table->unsignedInteger('sort')->comment('排序')->default(99);
            $table->string('name',50)->comment('权限名称');
            $table->string('controller',50)->comment('控制器');
            $table->string('action',50)->comment('方法');
            $table->string('icon',50)->comment('图标');
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
        Schema::dropIfExists('auth');
    }
}
