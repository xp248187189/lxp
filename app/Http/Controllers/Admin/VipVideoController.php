<?php

namespace App\Http\Controllers\Admin;

use App\Model\VipVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VipVideoController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('name')){
                $whereArray[] = ['name','like','%'.$request->input('name').'%'];
            }
            $data = VipVideo::where($whereArray)
                ->orderBy('sort','asc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.VipVideo.showList');
    }

    //添加页
    public function add(){
        return view('Admin.VipVideo.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new VipVideo();
        $orm->name = $request->input('name');
        $orm->url = $request->input('url');
        $orm->type = $request->input('type');
        $orm->status = $request->input('status');
        $orm->sort = $request->input('sort');
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $VipVideoInfo = VipVideo::find($id);
        return view('Admin.VipVideo.edit')->with('VipVideoInfo',$VipVideoInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = VipVideo::find($id);
        if ($request->input('name')){
            $orm->name = $request->input('name');
        }
        if ($request->input('url')){
            $orm->url = $request->input('url');
        }
        if ($request->input('type')){
            $orm->type = $request->input('type');
        }
        if ($request->input('status') !== null){
            $orm->status = $request->input('status');
        }
        if ($request->input('sort')){
            $orm->sort = $request->input('sort');
        }
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $ids = trim($ids,',');
        VipVideo::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
