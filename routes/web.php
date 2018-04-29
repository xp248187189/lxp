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
    //Auth控制器
    Route::middleware('AdminAuth')->prefix('Auth')->group(function (){
        //列表
        Route::any('/showList/{action?}/{id?}','AuthController@showList');
        //添加页
        Route::get('/add/{pid}/{level}/{id_list}','AuthController@add');
        //执行添加
        Route::post('/ajaxAdd','AuthController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','AuthController@edit');
        //执行修改
        Route::post('/ajaxEdit','AuthController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','AuthController@ajaxDel');
    });
    //Admin控制器
    Route::middleware('AdminAuth')->prefix('Admin')->group(function (){
        //列表
        Route::any('/showList/{action?}','AdminController@showList');
        //添加页
        Route::get('/add','AdminController@add');
        //执行添加
        Route::post('/ajaxAdd','AdminController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','AdminController@edit');
        //执行修改
        Route::post('/ajaxEdit','AdminController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','AdminController@ajaxDel');
    });
    //Role控制器
    Route::middleware('AdminAuth')->prefix('Role')->group(function (){
        //列表
        Route::any('/showList/{action?}','RoleController@showList');
        //添加页
        Route::get('/add','RoleController@add');
        //执行添加
        Route::post('/ajaxAdd','RoleController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','RoleController@edit');
        //执行修改
        Route::post('/ajaxEdit','RoleController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','RoleController@ajaxDel');
    });
    //Article控制器
    Route::middleware('AdminAuth')->prefix('Article')->group(function (){
        //首页
        Route::any('/showList/{action?}','ArticleController@showList');
        //添加页
        Route::get('/add','ArticleController@add');
        //执行添加
        Route::post('/ajaxAdd','ArticleController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','ArticleController@edit');
        //执行修改
        Route::post('/ajaxEdit','ArticleController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','ArticleController@ajaxDel');
    });
    //category控制器
    Route::middleware('AdminAuth')->prefix('Category')->group(function (){
        //首页
        Route::any('/showList/{action?}','CategoryController@showList');
        //添加页
        Route::get('/add','CategoryController@add');
        //执行添加
        Route::post('/ajaxAdd','CategoryController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','CategoryController@edit');
        //执行修改
        Route::post('/ajaxEdit','CategoryController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','CategoryController@ajaxDel');
    });
    //TimeAxis控制器
    Route::middleware('AdminAuth')->prefix('TimeAxis')->group(function (){
        //首页
        Route::any('/showList/{action?}','TimeAxisController@showList');
        //添加页
        Route::get('/add','TimeAxisController@add');
        //执行添加
        Route::post('/ajaxAdd','TimeAxisController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','TimeAxisController@edit');
        //执行修改
        Route::post('/ajaxEdit','TimeAxisController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','TimeAxisController@ajaxDel');
    });
    //ArticelComment控制器
    Route::middleware('AdminAuth')->prefix('ArticleComment')->group(function (){
        //首页
        Route::any('/showList/{action?}','ArticleCommentController@showList');
        //删除
        Route::get('/ajaxDel','ArticleCommentController@ajaxDel');
    });
    //Link控制器
    Route::middleware('AdminAuth')->prefix('Link')->group(function (){
        //首页
        Route::any('/showList/{action?}','LinkController@showList');
        //添加页
        Route::get('/add','LinkController@add');
        //执行添加
        Route::post('/ajaxAdd','LinkController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','LinkController@edit');
        //执行修改
        Route::post('/ajaxEdit','LinkController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','LinkController@ajaxDel');
    });
    //Blogger控制器
    Route::middleware('AdminAuth')->prefix('Blogger')->group(function (){
        //修改页
        Route::get('/show','BloggerController@show');
        //执行修改
        Route::post('/ajaxEdit','BloggerController@ajaxEdit');
    });
    //Link控制器
    Route::middleware('AdminAuth')->prefix('Notice')->group(function (){
        //首页
        Route::any('/showList/{action?}','NoticeController@showList');
        //添加页
        Route::get('/add','NoticeController@add');
        //执行添加
        Route::post('/ajaxAdd','NoticeController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','NoticeController@edit');
        //执行修改
        Route::post('/ajaxEdit','NoticeController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','NoticeController@ajaxDel');
    });
    //Blog控制器
    Route::middleware('AdminAuth')->prefix('Blog')->group(function (){
        //修改页
        Route::get('/show','BlogController@show');
        //执行修改
        Route::post('/ajaxEdit','BlogController@ajaxEdit');
    });
    //Seo控制器
    Route::middleware('AdminAuth')->prefix('Seo')->group(function (){
        //修改页
        Route::get('/show','SeoController@show');
        //执行修改
        Route::post('/ajaxEdit','SeoController@ajaxEdit');
    });
    //Note控制器
    Route::middleware('AdminAuth')->prefix('Note')->group(function (){
        //首页
        Route::any('/showList/{action?}','NoteController@showList');
        //添加页
        Route::get('/add','NoteController@add');
        //执行添加
        Route::post('/ajaxAdd','NoteController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','NoteController@edit');
        //执行修改
        Route::post('/ajaxEdit','NoteController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','NoteController@ajaxDel');
    });
    //adminLogin控制器
    Route::middleware('AdminAuth')->prefix('AdminLogin')->group(function (){
        //首页
        Route::any('/showList/{action?}','AdminLoginController@showList');
        //删除
        Route::get('/ajaxDel','AdminLoginController@ajaxDel');
    });
    //userLogin控制器
    Route::middleware('AdminAuth')->prefix('UserLogin')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserLoginController@showList');
        //删除
        Route::get('/ajaxDel','UserLoginController@ajaxDel');
    });
    //User控制器
    Route::middleware('AdminAuth')->prefix('User')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserController@showList');
        //执行修改
        Route::post('/ajaxEdit','UserController@ajaxEdit');
    });
    //UserComment控制器
    Route::middleware('AdminAuth')->prefix('UserComment')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserCommentController@showList');
        //删除
        Route::get('/ajaxDel','UserCommentController@ajaxDel');
    });
});
