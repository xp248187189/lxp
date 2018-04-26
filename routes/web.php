<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * 后台
 */
Route::namespace('Admin')->prefix('myadmin')->group(function () {
    //登陆页面
    Route::get('login','LoginController@login');
    //执行登陆
    Route::post('doLogin','LoginController@doLogin');
    //退出登陆
    Route::get('doLogOut','LoginController@doLogOut');
    //登录验证码
    // Route::get();
    //Index控制器
    Route::middleware('AdminAuth')->prefix('Index')->group(function (){
        //首页
        Route::get('/index','IndexController@index');
        //welcome页
        Route::get('/welcome','IndexController@welcome');
        //修改个人信息
        Route::get('/editMe','IndexController@editMe');
        //ajax执行修改个人信息
        Route::post('/ajaxEdit','IndexController@ajaxEdit');
    });
});
