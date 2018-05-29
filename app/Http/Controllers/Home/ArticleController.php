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
        //关键字
        $keyWordsInfo = Cache::remember(sha1($request->fullUrl().'_keyWordsInfo_cache'),10,function (){
            return About::find(3);
        });
        //描述
        $descriptionInfo = Cache::remember(sha1($request->fullUrl().'_descriptionInfo_cache'),10,function (){
            return About::find(4);
        });
        //关于博客
        $blogInfo = Cache::remember(sha1($request->fullUrl().'_blogInfo_cache'),10,function (){
            return About::find(2);
        });
        //分类
        $categoryList = Cache::remember(sha1($request->fullUrl().'_categoryList_cache'),10,function (){
            return Category::where('status','=','1')
                ->get();
        });
        $keyWord = '';
        $category = 0;
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
        }else if(trim(\Route::input('keyWord')) !== ''){
            $titleName = trim(\Route::input('keyWord'));
            $keyWord = trim(\Route::input('keyWord'));
        }else{
            $titleName = '文章专栏';
        }
        //作者推荐
        $isRecommendList = Cache::remember(sha1($request->fullUrl().'_isRecommendList_cache'),10,function (){
            return Article::where('status','=','1')
                ->where('isRecommend','=','1')
                ->orderBy('sort','asc')
                ->orderBy('addTime','desc')
                ->select('id','title')
                ->take(8)
                ->get();
        });
        //随便看看
        $suijiList = Cache::remember(sha1($request->fullUrl().'_suijiList_cache'),10,function (){
            return Article::where('status','=','1')
                ->inRandomOrder()
                ->select('id','title')
                ->take(8)
                ->get();
        });
        return view('Home.Article.articleList')->with('blogInfo',$blogInfo)
            ->with('categoryList',$categoryList)
            ->with('isRecommendList',$isRecommendList)
            ->with('suijiList',$suijiList)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('titleName',$titleName)
            ->with('keyWord',$keyWord)
            ->with('category',$category)
            ->with('controllerName','Article');
    }

    //ajax获取流数据
    public function getData(Request $request){
        //where条件
        $whereArray = [];
        $whereArray[] = ['status','=','1'];
        if (intval(\Route::input('category'))){
            $whereArray[] = ['category_id','=',intval(\Route::input('category'))];
        }
        if (trim(\Route::input('keyWord'))){
            $whereArray[] = ['title','like','%'.trim(\Route::input('keyWord')).'%'];
        }
        //查询数据并写入缓存
        $list = Cache::remember(sha1($request->fullUrl().'_list_cache'),10,function () use ($whereArray){
            return Article::where($whereArray)
                ->orderBy('sort','asc')
                ->orderBy('addTime','desc')
                ->paginate(8);
        });
        //判断是否有数据
        if ($list->isEmpty()){
            //没有数据的话，随机查询8条数据，因为是随机，所以不写缓存
            $list = Cache::remember(sha1($request->fullUrl().'_inRandomOrderList_cache'),10,function (){
                return Article::inRandomOrder()
                    ->where('status','=','1')
                    ->take(8)
                    ->get();
            });
            //返回数据
            return ['data'=>$list,'pageCount'=>0];
        }else{
            //返回数据
            $list = $list->toArray();
            return ['data'=>$list['data'],'pageCount'=>$list['last_page']];
        }
    }

    //详情
    public function detail(){
        $id = intval(\Route::input('id'));
        $info = Article::find($id);
        if (empty($info)){
            abort(404);
        }
        Article::where('id','=',$id)->increment('showNum');
        //关键字
        $keyWordsInfo = About::find(3);
        //描述
        $descriptionInfo = About::find(4);
        //关于博客
        $blogInfo = About::find(2);
        //分类
        $categoryList = Category::where('status','=','1')
            ->get();
        //相似推荐
        $xiangshiList = Article::where('status','=','1')
            ->where('category_id','=',$info->category_id)
            ->orderBy('sort','asc')
            ->orderBy('addTime','desc')
            ->select('id','title')
            ->take(8)
            ->get();
        //随便看看
        $suijiList = Article::where('status','=','1')
            ->inRandomOrder()
            ->select('id','title')
            ->take(8)
            ->get();
        //判断是否登录
        if(\Cookie::has('user_openid')){
            $isLogin = true;
        }else{
            $isLogin = false;
        }
        return view('Home.Article.detail')->with('blogInfo',$blogInfo)
            ->with('categoryList',$categoryList)
            ->with('xiangshiList',$xiangshiList)
            ->with('suijiList',$suijiList)
            ->with('info',$info)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','Article')
            ->with('isLogin',$isLogin);
    }

    //获取评论
    public function getArticleComment(){
        $articleId = intval(\Route::input('articleId'));
        $count = ArticleComment::where('article_id','=',$articleId)->count();
        $articleComment = ArticleComment::where('article_id','=',$articleId)
            ->orderBy('time','desc')
            ->paginate(8)
            ->toArray()['data'];
        $pageCount = ceil($count/8);
        return ['data'=>$articleComment,'pageCount'=>$pageCount];
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