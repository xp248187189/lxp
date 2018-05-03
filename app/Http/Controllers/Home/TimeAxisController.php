<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\TimeAxis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeAxisController extends Controller
{
    public function timeAxis(){
        $year = TimeAxis::where('status','=','1')
            ->orderBy('year','desc')
            ->groupBy('year')
            ->select('year')
            ->get();
        foreach ($year as $k => $v){
            $year[$k]['zi'] = TimeAxis::where('status','=','1')
                ->where('year','=',$v['year'])
                ->orderBy('month','desc')
                ->groupBy('month')
                ->select('month')
                ->get();
            foreach ($year[$k]['zi'] as $kk => $vv) {
                $year[$k]['zi'][$kk]['zi'] = TimeAxis::where('status','=','1')
                    ->where('year','=',$v['year'])
                    ->where('month','=',$vv['month'])
                    ->orderBy('day','desc')
                    ->get();
            }
        }
        //关于博客
        $blogInfo = About::find(2);
        //关键字
        $keyWordsInfo = About::find(3);
        //描述
        $descriptionInfo = About::find(4);
        return view('Home.TimeAxis.timeAxis')->with('timeAxisList',$year)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','TimeAxis');
    }
}
