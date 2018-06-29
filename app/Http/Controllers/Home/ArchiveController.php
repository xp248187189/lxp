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
        //归档列表
        $new_list = Cache::remember(sha1($request->fullUrl().'_archiveList_cache'),10,function (){
             $list = Article::where('status','=','1')
                ->orderBy('created_at','desc')
                ->select('id','title','addDate')
                ->get()
                ->toArray();
            foreach ($list as $key => $value){
                $list[$key]['addYearMonth'] = substr($value['addDate'],0,7);
            }
            return arrayGroupBy($list,'addYearMonth');
        });
        return view('Home.Archive.archive')->with('archiveList',$new_list)
            ->with('controllerName','Archive');
    }
}
