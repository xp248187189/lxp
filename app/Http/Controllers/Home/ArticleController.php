<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\Article;
use App\Model\Category;
use App\Model\ArticleComment;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //列表
    public function articleList(){
        //关键字
        $keyWordsInfo = About::find(3);
        //描述
        $descriptionInfo = About::find(4);
        //关于博客
        $blogInfo = About::find(2);
        //分类
        $categoryList = Category::where('status','=','1')
            ->get();
        $keyWord = '';
        $category = 0;
        //设置title
        if (intval(\Route::input('category'))){
            $categoryName = Category::find(intval(\Route::input('category')));
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
        $isRecommendList = Article::where('status','=','1')
            ->where('isRecommend','=','1')
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
    public function getData(){
        $whereArray = [];
        $whereArray[] = ['status','=','1'];
        if (intval(\Route::input('category'))){
            $whereArray[] = ['category_id','=',intval(\Route::input('category'))];
        }
        if (trim(\Route::input('keyWord'))){
            $whereArray[] = ['title','like','%'.trim(\Route::input('keyWord')).'%'];
        }
        $count = Article::where($whereArray)->count();
        if ($count){
            $pageCount = ceil($count/8);
            $list = Article::where($whereArray)
                ->orderBy('sort','asc')
                ->orderBy('addTime','desc')
                ->paginate(8);
                // ->toArray()['data'];
        }else{
            $pageCount = 0;
            $list = Article::inRandomOrder()
                ->where('status','=','1')
                ->take(8)
                ->get();
        }
        foreach ($list as $key => $value){
            // $list[$key]['commentCount'] = ArticleComment::where('article_id','=',$value['id'])->count();
            $list[$key]['commentCount'] = count($value->getCommentCount);
        }
        if ($count){
            //这里要 >$list->toArray()['data'] 是因为 paginate 分页会带上 总页数，当前页数，每页条数。。。的信息，这里要去掉这些信息只保留数据
            exit(json_encode(array('data'=>$list->toArray()['data'],'pageCount'=>$pageCount)));
        }else{
            exit(json_encode(array('data'=>$list,'pageCount'=>$pageCount)));
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
        exit(json_encode(array('data'=>$articleComment,'pageCount'=>$pageCount)));
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
        exit(json_encode(array('status'=>true,'echo'=>'评论成功')));
    }
}
