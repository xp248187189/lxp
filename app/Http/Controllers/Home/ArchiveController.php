<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ArchiveController extends Controller
{
    public function archive(Request $request){
        //关于博客
        $blogInfo = Cache::remember(sha1($request->fullUrl().'_blogInfo_cache'),10,function (){
            return About::find(2);
        });
        //关键字
        $keyWordsInfo = Cache::remember(sha1($request->fullUrl().'_keyWordsInfo_cache'),10,function (){
            return About::find(3);
        });
        //描述
        $descriptionInfo = Cache::remember(sha1($request->fullUrl().'_descriptionInfo_cache'),10,function (){
            return About::find(4);
        });
        //归档列表
        $list = Cache::remember(sha1($request->fullUrl().'_archiveList_cache'),10,function (){
             return Article::where('status','=','1')
                ->orderBy('created_at','desc')
                ->select('id','title','addDate')
                ->get()
                ->toArray();
        });
        foreach ($list as $key => $value){
            $list[$key]['addYearMonth'] = substr($value['addDate'],0,7);
        }
        $new_list = arrayGroupBy($list,'addYearMonth');
        return view('Home.Archive.archive')->with('archiveList',$new_list)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','Archive');
    }
}
