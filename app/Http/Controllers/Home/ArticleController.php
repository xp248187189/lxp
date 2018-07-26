<?php

namespace App\Http\Controllers\Home;

use Carbon\Carbon;
use App\Jobs\CountArticleComment;
use App\Model\About;
use App\Model\Article;
use App\Model\Category;
use App\Model\ArticleComment;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    //列表
    public function articleList(Request $request){
        //分类
        $categoryList = Cache::remember(sha1($request->fullUrl().'_categoryList_cache'),10,function (){
            return Category::where('status','=','1')
                ->get();
        });
        $keyWord = '';
        $category = 0;
        $whereArray = [];
        $whereArray[] = ['status','=','1'];
        //设置title
        if (intval(\Route::input('category'))){
            $categoryName = Cache::remember(sha1($request->fullUrl().'_categoryName_cache'),10,function (){
                return Category::find(intval(\Route::input('category')));
            });
            if (empty($categoryName)){
                abort(404);
            }
            $titleName = $categoryName->name;
            $category = intval(\Route::input('category'));
            $whereArray[] = ['category_id','=',$category];
        }else if(trim(\Route::input('keyWord')) !== ''){
            $titleName = trim(\Route::input('keyWord'));
            $keyWord = trim(\Route::input('keyWord'));
            $whereArray[] = ['title','like','%'.$keyWord.'%'];
        }else{
            $titleName = '文章专栏';
        }
        //查询数据
        $articleList = Cache::remember(sha1($request->fullUrl().'_articleList_cache'),10,function () use ($whereArray){
            return Article::where($whereArray)
                ->orderBy('sort','asc')
                ->orderBy('created_at','desc')
                ->paginate(8,['*'],'p');
        });
        $hasArticleList = true;
        if ($articleList->isEmpty()){
            //没有数据的话，随机查询8条数据
            $articleList = Cache::remember(sha1($request->fullUrl().'_inRandomOrderList_cache'),10,function (){
                return Article::inRandomOrder()
                    ->where('status','=','1')
                    ->take(8)
                    ->get();
            });
            $hasArticleList = false;
        }
        // //根据图片接口获取图片
        // $imgList = Cache::remember(sha1($request->fullUrl().'_imgList_cache'),15,function (){
        //     //获取图片类别
        //     $params = [
        //         'showapi_appid' => config('api.showapi_appid'),
        //         'showapi_sign' => config('api.showapi_sign'),
        //     ];
        //     $res = curl('https://route.showapi.com/852-1',$params,false,true);
        //     $res = json_decode($res,true);
        //     //把所有图片类别id放在一个数组
        //     $typeList = [];
        //     foreach ($res['showapi_res_body']['list'] as $key => $value){
        //         foreach ($value['list'] as $k => $v){
        //             $typeList[] = $v;
        //         }
        //     }
        //     //获取图片
        //     $params = [
        //         'showapi_appid' => config('api.showapi_appid'),
        //         'showapi_sign' => config('api.showapi_sign'),
        //         'type' => $typeList[array_rand($typeList)]['id'],
        //     ];
        //     $res = curl('https://route.showapi.com/852-2',$params,false,true);
        //     $res = json_decode($res,true);
        //     $imgList = [];
        //     foreach ($res['showapi_res_body']['pagebean']['contentlist'] as $key => $value){
        //         foreach ($value['list'] as $k => $v){
        //             $imgList[] = $v['middle'];
        //         }
        //     }
        //     return $imgList;
        // });
        //作者推荐
        $isRecommendList = Cache::remember(sha1($request->fullUrl().'_isRecommendList_cache'),10,function (){
            return Article::where('status','=','1')
                ->where('isRecommend','=','1')
                ->orderBy('sort','asc')
                ->orderBy('created_at','desc')
                ->select('id','title')
                ->get();
        });
        return view('Home.Article.articleList')->with('categoryList',$categoryList)
            ->with('isRecommendList',$isRecommendList)
            ->with('titleName',$titleName)
            ->with('keyWord',$keyWord)
            ->with('category',$category)
            ->with('articleList',$articleList)
            // ->with('imgList',$imgList)
            ->with('hasArticleList',$hasArticleList);
    }

    //详情
    public function detail(Request $request){
        $id = intval(\Route::input('id'));
        //查询文章详细信息
        $info = Cache::remember(sha1($request->fullUrl().'_info_cache'),10,function () use ($id){
            return Article::find($id);
        });
        if (empty($info)){
            abort(404);
        }
        if (\Route::input('iframeGetData') == 'get'){
            showUEditorContent($info->content);
            exit;
        }
        //浏览次数递增
        Article::where('id','=',$id)->increment('showNum');
        //分类
        $categoryList = Cache::remember(sha1($request->fullUrl().'_categoryList_cache'),10,function (){
            return Category::where('status','=','1')
                ->get();
        });
        //作者推荐
        $isRecommendList = Cache::remember(sha1($request->fullUrl().'_isRecommendList_cache'),10,function (){
            return Article::where('status','=','1')
                ->where('isRecommend','=','1')
                ->orderBy('sort','asc')
                ->orderBy('created_at','desc')
                ->select('id','title')
                ->get();
        });
        //评论
        $articleComment = ArticleComment::where('article_id','=',$id)
            ->orderBy('time','desc')
            ->paginate(8,['*'],'p');
        //判断是否登录
        if(\Cookie::has('user_openid')){
            $isLogin = true;
        }else{
            $isLogin = false;
        }
        return view('Home.Article.detail')->with('categoryList',$categoryList)
            ->with('isRecommendList',$isRecommendList)
            ->with('info',$info)
            ->with('articleComment',$articleComment)
            ->with('isLogin',$isLogin);
    }

    //提交评论
    public function articleComment(Request $request){
        $openid = \Cookie::get('user_openid');
        $userInfo = User::where('connectid','=',$openid)->first();
        $articleCommentOrm = new ArticleComment();
        $articleCommentOrm->article_id = $request->input('articleId');
        $articleCommentOrm->article_name = '';
        $articleCommentOrm->user_id = $userInfo->id;
        $articleCommentOrm->user_account = '';
        $articleCommentOrm->user_head = '';
        $articleCommentOrm->time = time();
        $articleCommentOrm->connect = $request->input('editorContent');
        $articleCommentOrm->save();
        //用队列修改评论数
        CountArticleComment::dispatch($request->input('articleId'),1)->onQueue('countArticleComment');
        return ['status'=>true,'echo'=>'评论成功'];
    }
}