<?php

namespace App\Http\Controllers\Admin;

use App\Model\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('content')){
                $whereArray[] = ['content','like','%'.$request->input('content').'%'];
            }
            $return['count'] = Notice::where($whereArray)->count();
            $return['data'] = Notice::where($whereArray)
                ->orderBy('sort','asc')
                ->paginate($request->input('limit'))
                ->toArray()['data'];
            return $return;
        }
        return view('Admin.Notice.showList');
    }

    //添加页
    public function add(){
        return view('Admin.Notice.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new Notice();
        $orm->content = $request->input('content');
        $orm->sort = $request->input('sort');
        $orm->status = $request->input('status');
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $NoticeInfo = Notice::find($id);
        return view('Admin.Notice.edit')->with('NoticeInfo',$NoticeInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = Notice::find($id);
        if ($request->input('content')){
            $orm->content = $request->input('content');
        }
        if ($request->input('sort')){
            $orm->sort = $request->input('sort');
        }
        if ($request->input('status') !== null){
            $orm->status = $request->input('status');
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
        Notice::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
