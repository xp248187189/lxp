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
                    ->paginate($request->input('limit'))
                    ->toArray();
            });
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        //api
        $vipVideoApi = Cache::remember(sha1($request->fullUrl().'_vipVideoApi_cache'),10,function (){
            return VipVideo::where('status','=','1')->where('type','=','1')->orderBy('sort','asc')->get();
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
        return view('Home.VipVideo.vipVideo')->with('vipVideoApi',$vipVideoApi)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('controllerName','VipVideo');
    }
}
