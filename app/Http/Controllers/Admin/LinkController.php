<?php

namespace App\Http\Controllers\Admin;

use App\Model\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
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
            $data = Link::where($whereArray)
                ->orderBy('sort','asc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.Link.showList');
    }

    //添加页
    public function add(){
        return view('Admin.Link.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new Link();
        $orm->name = $request->input('name');
        $orm->url = $request->input('url');
        $orm->sort = $request->input('sort');
        $orm->isHome = $request->input('isHome');
        $orm->status = $request->input('status');
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $LinkInfo = Link::find($id);
        return view('Admin.Link.edit')->with('LinkInfo',$LinkInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = Link::find($id);
        if ($request->input('name')){
            $orm->name = $request->input('name');
        }
        if ($request->input('url')){
            $orm->url = $request->input('url');
        }
        if ($request->input('sort')){
            $orm->sort = $request->input('sort');
        }
        if ($request->input('isHome') !== null){
            $orm->isHome = $request->input('isHome');
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
        Link::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
