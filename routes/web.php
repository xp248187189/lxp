<?php

/**
 * 前台
 */
Route::domain(config('domin.home_domin'))->namespace('Home')->middleware('BlackList','throttle:60,1')->group(function (){
    //首页
    Route::get('/','IndexController@index');
    //文章列表 全部/分类/标题
    Route::get('Article','ArticleController@articleList');
    Route::get('Category/{category}','ArticleController@articleList')->where('category','[0-9]+');
    Route::get('Search/{keyWord}','ArticleController@articleList');
    //文章详情
    Route::get('Detail/{id}/{iframeGetData?}','ArticleController@detail')->where('id','[0-9]+');
    //提交评论
    Route::post('ArticleComment','ArticleController@articleComment');
    //文章归档
    Route::get('Archive','ArchiveController@archive');
    //时间轴
    Route::get('TimeAxis','TimeAxisController@timeAxis');
    //轻松一刻
    Route::get('Joke','JokeController@joke');
    //关于本站
    Route::get('About','AboutController@about');
    //提交留言
    Route::post('UserComment','AboutController@userComment');
    //QQ登录
    Route::get('qqLogin','UserController@qqLogin');
    //退出登陆
    Route::get('userLogOut','UserController@userLogOut');
    //vip视频解析
    Route::get('vip/{action?}','VipVideoController@vipVideo');
    //高清图集
    Route::get('atlas/{action?}','BingImgController@atlas');
});

/**
 * 后台
 */
Route::domain(config('domin.admin_domin'))->namespace('Admin')->group(function () {
    //登陆页面
    Route::get('login','LoginController@login');
    //执行登陆
    Route::post('doLogin','LoginController@doLogin')->middleware('throttleForJson:5,5');
    //退出登陆
    Route::get('doLogOut','LoginController@doLogOut');
});
Route::domain(config('domin.admin_domin'))->namespace('Admin')->middleware('AdminAuth')->group(function () {
    //默认Index/index页面
    Route::get('/','IndexController@index');

    //Index控制器
    Route::prefix('Index')->group(function (){
        //首页
        Route::get('/index','IndexController@index');
        //welcome页
        Route::get('/welcome','IndexController@welcome');
        //修改个人信息
        Route::get('/editMe','IndexController@editMe');
        //ajax执行修改个人信息
        Route::post('/ajaxEdit','IndexController@ajaxEdit');
        //查看phpinfo
        Route::get('/showPhpInfo','IndexController@showPhpInfo');
        //清空缓存
        Route::get('/cacheFlush','IndexController@cacheFlush');
        //验证密码 -- 锁屏
        Route::post('/checkPassWord','IndexController@checkPassWord')->middleware('throttleForJson:5,5');
        //锁屏
        Route::post('/lockView','IndexController@lockView');
        //判断是否锁屏
        Route::post('/checkIsLockView','IndexController@checkIsLockView');
    });
    //Auth控制器
    Route::prefix('Auth')->group(function (){
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
    Route::prefix('Admin')->group(function (){
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
        Route::post('/ajaxDel','AdminController@ajaxDel');
    });
    //Role控制器
    Route::prefix('Role')->group(function (){
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
    Route::prefix('Article')->group(function (){
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
        //评论
        Route::any('/commentList/{article_id}/{action?}','ArticleController@commentList');
    });
    //category控制器
    Route::prefix('Category')->group(function (){
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
    Route::prefix('TimeAxis')->group(function (){
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
    Route::prefix('ArticleComment')->group(function (){
        //首页
        Route::any('/showList/{action?}','ArticleCommentController@showList');
        //删除
        Route::get('/ajaxDel','ArticleCommentController@ajaxDel');
    });
    //Link控制器
    Route::prefix('Link')->group(function (){
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
    Route::prefix('Blogger')->group(function (){
        //修改页
        Route::get('/show','BloggerController@show');
        //执行修改
        Route::post('/ajaxEdit','BloggerController@ajaxEdit');
    });
    //Link控制器
    Route::prefix('Notice')->group(function (){
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
    Route::prefix('Blog')->group(function (){
        //修改页
        Route::get('/show','BlogController@show');
        //执行修改
        Route::post('/ajaxEdit','BlogController@ajaxEdit');
    });
    //Seo控制器
    Route::prefix('Seo')->group(function (){
        //修改页
        Route::get('/show','SeoController@show');
        //执行修改
        Route::post('/ajaxEdit','SeoController@ajaxEdit');
    });
    //Note控制器
    Route::prefix('Note')->group(function (){
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
    Route::prefix('AdminLogin')->group(function (){
        //首页
        Route::any('/showList/{action?}','AdminLoginController@showList');
        //删除
        Route::post('/ajaxDel','AdminLoginController@ajaxDel');
    });
    //userLogin控制器
    Route::prefix('UserLogin')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserLoginController@showList');
        //删除
        Route::get('/ajaxDel','UserLoginController@ajaxDel');
    });
    //User控制器
    Route::prefix('User')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserController@showList');
        //执行修改
        Route::post('/ajaxEdit','UserController@ajaxEdit');
    });
    //UserComment控制器
    Route::prefix('UserComment')->group(function (){
        //首页
        Route::any('/showList/{action?}','UserCommentController@showList');
        //删除
        Route::get('/ajaxDel','UserCommentController@ajaxDel');
        //回复页
        Route::any('/showHuiFuList/{id}/{action?}','UserCommentController@showHuiFuList');
    });
    //BlackList控制器
    Route::prefix('BlackList')->group(function (){
        //首页
        Route::any('/showList/{action?}','BlackListController@showList');
        //添加页
        Route::get('/add','BlackListController@add');
        //执行添加
        Route::post('/ajaxAdd','BlackListController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','BlackListController@edit');
        //执行修改
        Route::post('/ajaxEdit','BlackListController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','BlackListController@ajaxDel');
    });
    //VipVideo控制器
    Route::prefix('VipVideo')->group(function (){
        //首页
        Route::any('/showList/{action?}','VipVideoController@showList');
        //添加页
        Route::get('/add','VipVideoController@add');
        //执行添加
        Route::post('/ajaxAdd','VipVideoController@ajaxAdd');
        //修改页
        Route::get('/edit/{id}','VipVideoController@edit');
        //执行修改
        Route::post('/ajaxEdit','VipVideoController@ajaxEdit');
        //删除
        Route::get('/ajaxDel','VipVideoController@ajaxDel');
    });
});
