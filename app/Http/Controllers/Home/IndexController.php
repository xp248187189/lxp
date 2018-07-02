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
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    //首页
    public function index(Request $request){
        //首页文章(推荐文章)
        $isHomeList = Cache::remember(sha1($request->fullUrl().'_isHomeList_cache'),10,function (){
            return Article::where('status','=','1')
                ->where('isRecommend','=','1')
                ->orderBy('sort','asc')
                ->orderBy('created_at','desc')
                //->take(8)
                ->get();
        });
        if ($isHomeList->isEmpty()){//inRandomOrder
            $isHomeList = Cache::remember(sha1($request->fullUrl().'_inRandomOrder_cache'),10,function (){
                return Article::inRandomOrder()
                    ->where('status','=','1')
                    ->take(8)
                    ->get();
            });
        }
        //最新文章
        $newestList = Cache::remember(sha1($request->fullUrl().'_newestList_cache'),10,function (){
            return Article::where('status','=','1')
                ->orderBy('created_at','desc')
                ->orderBy('sort','asc')
                ->select('id','title')
                ->take(8)
                ->get();
        });
        //一路走来
        $timeAxisList = Cache::remember(sha1($request->fullUrl().'_timeAxisList_cache'),10,function (){
            return TimeAxis::where('status','=','1')
                ->where('isHome','=','1')
                ->orderBy('year','desc')
                ->orderBy('month','desc')
                ->orderBy('day','desc')
                ->orderBy('hour','desc')
                ->orderBy('minute','desc')
                ->take(8)
                ->get();
        });
        //友情链接
        $linkList = Cache::remember(sha1($request->fullUrl().'_linkList_cache'),10,function (){
            return Link::where('status','=','1')
                ->where('isHome','=','1')
                ->orderBy('sort','asc')
                ->get();
        });
        //网站公告
        $noticeList = Cache::remember(sha1($request->fullUrl().'_noticeList_cache'),10,function (){
            return Notice::where('status','=','1')
                ->orderBy('sort','asc')
                ->get();
        });
        return view('Home.Index.index')->with('newestList',$newestList)
            ->with('timeAxisList',$timeAxisList)
            ->with('linkList',$linkList)
            ->with('noticeList',$noticeList)
            ->with('isHomeList',$isHomeList);
    }
}
