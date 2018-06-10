<?php

namespace App\Http\Controllers\Admin;

use App\Model\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoteController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('name')){
                $whereArray[] = ['title','like','%'.$request->input('name').'%'];
            }
            $data = Note::where($whereArray)
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.Note.showList');
    }

    //添加页
    public function add(){
        return view('Admin.Note.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new Note();
        $orm->title = is_null($request->input('title'))?'':$request->input('title');
        $orm->url = is_null($request->input('url'))?'':$request->input('url');
        $orm->account = is_null($request->input('account'))?'':$request->input('account');
        $orm->password = is_null($request->input('password'))?'':$request->input('password');
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $NoteInfo = Note::find($id);
        return view('Admin.Note.edit')->with('NoteInfo',$NoteInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = Note::find($id);
        $orm->title = is_null($request->input('title'))?'':$request->input('title');
        $orm->url = is_null($request->input('url'))?'':$request->input('url');
        $orm->account = is_null($request->input('account'))?'':$request->input('account');
        $orm->password = is_null($request->input('password'))?'':$request->input('password');
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
        Note::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
