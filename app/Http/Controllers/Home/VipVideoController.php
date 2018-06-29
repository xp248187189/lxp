<?php

namespace App\Http\Controllers\Home;

use App\Model\VipVideo;
use App\Model\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VipVideoController extends Controller
{
    public function vipVideo(Request $request){
        //播放地址
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            $whereArray[] = ['status','=','1'];
            $whereArray[] = ['type','=','2'];
            if ($request->input('name')){
                $whereArray[] = ['name','like','%'.$request->input('name').'%'];
            }
            $data = Cache::remember(sha1($request->fullUrl().'_vipVideoUrl_cache'),10,function () use ($whereArray,$request){
                return VipVideo::where($whereArray)
                    ->orderBy('sort','asc')
                    ->orderBy('id','asc')
                    ->paginate($request->input('limit'))
                    ->toArray();
            });
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        //api
        $vipVideoApi = Cache::remember(sha1($request->fullUrl().'_vipVideoApi_cache'),10,function (){
            return VipVideo::where('status','=','1')
                ->where('type','=','1')
                ->orderBy('sort','asc')
                ->orderBy('id','asc')
                ->get();
        });
        return view('Home.VipVideo.vipVideo')->with('vipVideoApi',$vipVideoApi)
            ->with('controllerName','VipVideo');
    }
}
