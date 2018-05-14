<?php

namespace App\Http\Controllers\Admin;

use App\Model\BlackList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlackListController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('ip')){
                $whereArray[] = ['ip','like','%'.$request->input('name').'%'];
            }
            $return['count'] = BlackList::where($whereArray)->count();
            $return['data'] = BlackList::where($whereArray)
                ->paginate($request->input('limit'))
                ->toArray()['data'];
            return $return;
        }
        return view('Admin.BlackList.showList');
    }

    //添加页
    public function add(){
        return view('Admin.BlackList.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new BlackList();
        $orm->ip = $request->input('ip');
        $orm->status = $request->input('status');
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $BlackListInfo = BlackList::find($id);
        return view('Admin.BlackList.edit')->with('BlackListInfo',$BlackListInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = BlackList::find($id);
        if ($request->input('ip')){
            $orm->ip = $request->input('ip');
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
        BlackList::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
