<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\TimeAxis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TimeAxisController extends Controller
{
    public function timeAxis(Request $request){
        $yearGroup = Cache::remember(sha1($request->fullUrl().'_yearGroup_cache'),10,function (){
            //查询数据
            $timeAxisList = TimeAxis::where('status','=','1')
                ->where('isHome','=','1')
                ->orderBy('year','desc')
                ->orderBy('month','desc')
                ->orderBy('day','desc')
                ->orderBy('hour','desc')
                ->orderBy('minute','desc')
                ->get()
                ->toArray();
            //根据年分组
            $yearGroup = arrayGroupBy($timeAxisList,'year');
            foreach ($yearGroup as $k => $v){
                //根据月分组
                $yearGroup[$k] = arrayGroupBy($v,'month');
            }
            return $yearGroup;
        });
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
        return view('Home.TimeAxis.timeAxis')->with('timeAxisList',$yearGroup)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','TimeAxis');
    }
}
