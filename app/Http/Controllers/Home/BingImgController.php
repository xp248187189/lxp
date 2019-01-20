<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Cache;
use App\Model\BingImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BingImgController extends Controller
{
    public function atlas(Request $request){
        $bingImgList = Cache::remember(sha1($request->fullUrl() . '_atlas_cache'), 10, function () {
            return BingImg::orderBy('date', 'desc')
                ->paginate(20, ['*'], 'p');
        });
        $hasBingImgList = true;
        if($bingImgList->isEmpty()){
            $bingImgList = Cache::remember(sha1($request->fullUrl() . '_inRandomOrderList_cache'), 10, function () {
                return BingImg::inRandomOrder()
                    ->take(20)
                    ->get();
            });
            $hasBingImgList = false;
        }
        return view('Home.BingImg.atlas')->with('bingImgList',$bingImgList)
            ->with('hasBingImgList',$hasBingImgList);
    }
}
