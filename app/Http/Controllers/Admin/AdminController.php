<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

class AdminController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action') == 'getData'){
            //设置条件
            $where[] = ['id', '<>', 1];
            $orWhere = [];
            if($request->filled('keyWord')){
                $orWhere[] = ['account', 'like', '%' . $request->input('keyWord') . '%'];
                $orWhere[] = ['name'   , 'like', '%' . $request->input('keyWord') . '%'];
                $orWhere[] = ['phone'  , 'like', '%' . $request->input('keyWord') . '%'];
                $orWhere[] = ['email'  , 'like', '%' . $request->input('keyWord') . '%'];
            }
            $request->filled('sex')     ? $where[] = ['sex', '=', $request->input('sex')]         : false;
            $request->filled('role_id') ? $where[] = ['role_id', '=', $request->input('role_id')] : false;
            //根据条件查询数据
            $data = Admin::where($where)
                ->where(function ($query) use ($orWhere){
                    foreach ($orWhere as $item) {
                        //orWhere好像不能用数组形式
                        $query->orWhere($item[0], $item[1], $item[2]);
                    }
                })
                ->paginate($request->input('limit'))
                ->toArray();
            //返回数据
            return ['code'=>0,'msg'=>'','count'=>$data['total'],'data'=>$data['data']];
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
        $res = [
            'status' => false,
            'echo'   => ''
        ];
        $info = Admin::where('account', $request->input('account'))->first();
        if($info){
            $res['echo'] = '此登录账号已被使用';
            return $res;
        }
        $adminOrm = new Admin();
        $adminOrm->account   = $request->input('account');
        $adminOrm->role_id   = $request->input('role_id');
        $adminOrm->role_name = '';
        $adminOrm->password  = Hash::make($request->input('password'));
        $adminOrm->name      = $request->input('name');
        $adminOrm->sex       = $request->input('sex');
        $adminOrm->phone     = $request->input('phone');
        $adminOrm->email     = $request->input('email');
        $adminOrm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页面
    public function edit(){
        $id = \Route::input('id');
        $adminInfo = Admin::find($id);
        //查询角色列表
        $roleList = Role::orderBy('sort','asc')->get();
        return view('Admin.Admin.edit')->with('roleList',$roleList)->with('adminInfo',$adminInfo);
    }

    //执行修改,列表上单个字段修改也用此方法，所以用了判断
    public function ajaxEdit(Request $request){
        //定义返回数据格式
        $res = [
            'status' => false,
            'echo'   => ''
        ];

        $id = $request->input('id');

        //判断是否重复
        $info = Admin::where('id', '<>', $id)
            ->where('account',$request->input('account'))
            ->first();

        if($info){
            $res['echo'] = '此登录账号已被使用';
            return $res;
        }

        //查询并保存数据
        $adminOrm = Admin::find($id);
        $request->filled('account') ? $adminOrm->account    = $request->input('account')              : false;
        $request->filled('role_id') ? $adminOrm->role_id    = $request->input('role_id')              : false;
        $request->filled('role_id') ? $adminOrm->role_name  = ''                                           : false;
        $request->filled('password')? $adminOrm->password   = Hash::make($request->input('password')) : false;
        $request->filled('name')    ? $adminOrm->name       = $request->input('name')                 : false;
        $request->filled('sex')     ? $adminOrm->sex        = $request->input('sex')                  : false;
        $request->filled('phone')   ? $adminOrm->phone      = $request->input('phone')                : false;
        $request->filled('email')   ? $adminOrm->email      = $request->input('email')                : false;
        $request->filled('status')  ? $adminOrm->status     = $request->input('status')               : false;
        $adminOrm->save();

        $res['status'] = true;
        $res['echo']   = '修改成功';
        return $res;
    }

    //删除
    public function ajaxDel(Request $request){
        $ids = $request->input('id');
        $ids = trim($ids,',');
        Admin::destroy(explode(',',$ids));
        return ['status' => true, 'echo' => '删除成功'];
    }
}
