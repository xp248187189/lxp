<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\Article;
use App\Model\ArticleComment;
use App\Model\Link;
use App\Model\Notice;
use App\Model\TimeAxis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function index(){
        //推荐文章
        $isRecommendList = Article::where('status','=','1')
            ->where('isRecommend','=','1')
            ->orderBy('sort','asc')
            ->orderBy('addTime','desc')
            ->select('id','title')
            ->take(8)
            ->get();
        //最新文章
        $newestList = Article::where('status','=','1')
            ->orderBy('addTime','desc')
            ->orderBy('sort','asc')
            ->select('id','title')
            ->take(8)
            ->get();
        //一路走来
        $timeAxisList = TimeAxis::where('status','=','1')
            ->where('isHome','=','1')
            ->orderBy('year','desc')
            ->orderBy('month','desc')
            ->orderBy('day','desc')
            ->orderBy('hour','desc')
            ->orderBy('minute','desc')
            ->take(8)
            ->get();
        //友情链接
        $linkList = Link::where('status','=','1')
            ->orderBy('sort','asc')
            ->get();
        //关于博客
        $blogInfo = About::find(2);
        //关于博主
        $bloggerInfo = About::find(1);
        //关键字
        $keyWordsInfo = About::find(3);
        //描述
        $descriptionInfo = About::find(4);
        //网站公告
        $noticeList = Notice::where('status','=','1')
            ->orderBy('sort','asc')
            ->get();
        return view('Home.Index.index')->with('isRecommendList',$isRecommendList)
            ->with('newestList',$newestList)
            ->with('timeAxisList',$timeAxisList)
            ->with('linkList',$linkList)
            ->with('blogInfo',$blogInfo)
            ->with('bloggerInfo',$bloggerInfo)
            ->with('noticeList',$noticeList)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','Index');
    }

    //ajax获取数据
    public function getDataForIndex(){
        //首页流加载文章
        $isHomeList = Article::where('status','=','1')
            ->where('isHome','=',1)
            ->orderBy('sort','asc')
            ->orderBy('addTime','desc')
            ->take(8)
            ->get();
        if ($isHomeList->isEmpty()){//inRandomOrder
            $isHomeList = Article::inRandomOrder()
                ->where('status','=','1')
                ->take(8)
                ->get();
        }
        foreach ($isHomeList as $key => $value){
            $isHomeList[$key]['commentCount'] = count($value->getCommentCount);
        }
        return ['data'=>$isHomeList,'pageCount'=>1];
    }
}
