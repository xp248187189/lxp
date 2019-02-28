<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Cache;
use App\Model\BingImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BingImgController extends Controller
{
    public function atlas(Request $request){
        //查表 -- 弃用
//        $bingImgList = Cache::remember(sha1($request->fullUrl() . '_atlas_cache'), 10, function () {
//            return BingImg::orderBy('date', 'desc')
//                ->paginate(20, ['*'], 'p');
//        });
//        $hasBingImgList = true;
//        if($bingImgList->isEmpty()){
//            $bingImgList = Cache::remember(sha1($request->fullUrl() . '_inRandomOrderList_cache'), 10, function () {
//                return BingImg::inRandomOrder()
//                    ->take(20)
//                    ->get();
//            });
//            $hasBingImgList = false;
//        }
        //接口查询最近15天的图片
        $hasBingImgList = true;
        $bingImgList = randGetBingEverydayImgForOnline(15);
        return view('Home.BingImg.atlas')->with('bingImgList',$bingImgList)
            ->with('hasBingImgList',$hasBingImgList);
    }
}
