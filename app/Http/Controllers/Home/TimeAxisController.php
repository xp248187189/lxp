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
        $year = Cache::remember(sha1($request->fullUrl().'_year_cache'),10,function (){
            return TimeAxis::where('status','=','1')
                ->orderBy('year','desc')
                ->groupBy('year')
                ->select('year')
                ->get();
        });
        foreach ($year as $k => $v){
            $year[$k]['zi'] = Cache::remember(sha1($request->fullUrl().'_year_'.$k.'_zi_cache'),10,function () use ($v){
                return TimeAxis::where('status','=','1')
                    ->where('year','=',$v['year'])
                    ->orderBy('month','desc')
                    ->groupBy('month')
                    ->select('month')
                    ->get();
            });
            foreach ($year[$k]['zi'] as $kk => $vv) {
                $year[$k]['zi'][$kk]['zi'] = Cache::remember($request->fullUrl().'_year_'.$k.'_zi_'.$kk.'_zi_cache',10,function () use ($v,$vv){
                    return TimeAxis::where('status','=','1')
                        ->where('year','=',$v['year'])
                        ->where('month','=',$vv['month'])
                        ->orderBy('day','desc')
                        ->get();
                });
            }
        }
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
        return view('Home.TimeAxis.timeAxis')->with('timeAxisList',$year)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','TimeAxis');
    }
}
