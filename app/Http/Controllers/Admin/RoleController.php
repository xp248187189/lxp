<?php

namespace App\Http\Controllers\Admin;

use App\Model\Auth;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = [];
            if($request->input('name')){
                $whereArray[] = ['name','like','%'.$request->input('name').'%'];
            }
            $return['count'] = Role::where($whereArray)->count();
            $return['data'] = Role::where($whereArray)->orderBy('sort','asc')->paginate($request->input('limit'))->toArray()['data'];
            //print_r($return);
            exit(json_encode($return));
        }
        return view('Admin.Role.showList');
    }

    //添加页
    public function add(){
        //查询所有菜单
        $one_authList = Auth::where('level','=',0)->get();
        $two_authList = Auth::where('level','=',1)->get();
        $three_authList = Auth::where('level','=',2)->get();
        return view('Admin.Role.add')->with('one_authList',$one_authList)
            ->with('two_authList',$two_authList)
            ->with('three_authList',$three_authList);
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $roleOrm = new Role();
        if ($request->input('auth_ids')){
            $roleOrm->auth_ids = implode(',',$request->input('auth_ids'));
        }else{
            $roleOrm->auth_ids = '';
        }
        $roleOrm->name = $request->input('name');
        $roleOrm->sort = $request->input('sort');
        $roleOrm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        exit(json_encode($res));
    }

    //修改
    public function edit(){
        $id = \Route::input('id');
        $roleInfo = Role::find($id);
        //查询所有菜单
        $one_authList = Auth::where('level','=',0)->get();
        $two_authList = Auth::where('level','=',1)->get();
        $three_authList = Auth::where('level','=',2)->get();
        return view('Admin.Role.edit')->with('one_authList',$one_authList)
            ->with('two_authList',$two_authList)
            ->with('three_authList',$three_authList)
            ->with('roleInfo',$roleInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $id = $request->input('id');
        $roleOrm = Role::find($id);
        if ($request->input('auth_ids')){
            $roleOrm->auth_ids = implode(',',$request->input('auth_ids'));
        }
        if($request->input('name')){
            $roleOrm->name = $request->input('name');
        }
        if($request->input('sort')){
            $roleOrm->sort = $request->input('sort');
        }
        $roleOrm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        exit(json_encode($res));
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $ids = trim($ids,',');
        Role::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        exit(json_encode($res));
    }
}
