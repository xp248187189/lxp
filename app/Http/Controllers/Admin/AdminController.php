<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArr[] = ['id','!=',1];
            $orWhereArr = [];
            if($request->input('keyWord')){
                $orWhereArr[] = ['account','like','%'.$request->input('keyWord').'%'];
                $orWhereArr[] = ['name','like','%'.$request->input('keyWord').'%'];
                $orWhereArr[] = ['phone','like','%'.$request->input('keyWord').'%'];
                $orWhereArr[] = ['email','like','%'.$request->input('keyWord').'%'];
            }
            if($request->input('sex')){
                $whereArr[] = ['sex','=',$request->input('sex')];
            }
            if($request->input('role_id')){
                $whereArr[] = ['role_id','=',$request->input('role_id')];
            }
            $return['count'] = Admin::where($whereArr)
                ->where(function ($query) use ($orWhereArr){
                    foreach ($orWhereArr as $item) {
                        //orWhere好像不能用数组形式
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->count();
            $return['data'] = Admin::where($whereArr)
                ->where(function ($query) use ($orWhereArr){
                    foreach ($orWhereArr as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->paginate($request->input('limit'))
                ->toArray()['data'];
            //print_r($return);
            exit(json_encode($return));
        }
        $roleList = Role::orderBy('sort','asc')->get();
        return view('Admin.Admin.showList')->with('roleList',$roleList);
    }

    //添加页
    public function add(){
        //查询角色列表
        $roleList = Role::orderBy('sort','asc')->get();
        return view('Admin.Admin.add')->with('roleList',$roleList);
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $info = Admin::get();
        $isUseAccount = 0;
        foreach ($info as $item) {
            if ($request->input('account') == $item['account']){
                $isUseAccount = 1;
                break;
            }
        }
        if($isUseAccount==1){
            $res['echo'] = '此登录账号已被使用';
            exit(json_encode($res));
        }
        $adminOrm = new Admin();
        $adminOrm->account = $request->input('account');
        $adminOrm->role_id = $request->input('role_id');
        $adminOrm->role_name = '';
        $adminOrm->password = md5($request->input('password'));
        $adminOrm->name = $request->input('name');
        $adminOrm->sex = $request->input('sex');
        $adminOrm->phone = $request->input('phone');
        $adminOrm->email = $request->input('email');
        $adminOrm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        exit(json_encode($res));
    }

    //修改页面
    public function edit(){
        $id = \Route::input('id');
        $adminInfo = Admin::find($id);
        //查询角色列表
        $roleList = Role::orderBy('sort','asc')->get();
        return view('Admin.Admin.edit')->with('roleList',$roleList)
            ->with('adminInfo',$adminInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $id = $request->input('id');
        $info = Admin::where('id','!=',$id)->get();
        if ($request->input('account')){
            $isUseAccount = 0;
            foreach ($info as $item) {
                if ($request->input('account') == $item['account']){
                    $isUseAccount = 1;
                    break;
                }
            }
            if($isUseAccount==1){
                $res['echo'] = '此登录账号已被使用';
                exit(json_encode($res));
            }
        }

        $adminOrm = Admin::find($id);
        if ($request->input('account')){
            $adminOrm->account = $request->input('account');
        }
        if ($request->input('role_id')){
            $adminOrm->role_id = $request->input('role_id');
            $adminOrm->role_name = '';
        }
        if ($request->input('password')){
            $adminOrm->password = md5($request->input('password'));
        }
        if ($request->input('name')){
            $adminOrm->name = $request->input('name');
        }
        if ($request->input('sex')){
            $adminOrm->sex = $request->input('sex');
        }
        if ($request->input('phone')){
            $adminOrm->phone = $request->input('phone');
        }
        if ($request->input('email')){
            $adminOrm->email = $request->input('email');
        }
        if ($request->input('status') !== null){
            $adminOrm->status = $request->input('status');
        }
        $adminOrm->save();
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
        Admin::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        exit(json_encode($res));
    }
}
