<?php

namespace App\Http\Controllers\Admin;

use App\Model\About;
use App\Model\Admin;
use App\Model\AdminLogin;
use App\Model\Article;
use App\Model\Auth;
use App\Model\Role;
use App\Model\User;
use App\Model\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页面
    public function index(){
        //博客信息
        $blogInfo = About::find(2);
        //判断是否是超级管理员
        if (session()->get('adminInfo')['id'] ==1){
            //查询权限信息 一级
            $authList = Auth::where('level',0)->get();
            foreach ($authList as $key => $value) {
                //查询权限信息 二级
                $s_authList = Auth::where('pid',$value['id'])
                    ->where('level',1)
                    ->get();
                if ($s_authList->isEmpty()) {
                    //没有二级权限，那么一级权限也不显示
                    unset($authList[$key]);
                }else{
                    $authList[$key]['s_authList'] = $s_authList;
                }
            }
        }else{
            //查询角色信息
            $roleInfo = Role::find(session()->get('adminInfo')['role_id']);
            if ($roleInfo['auth_ids']=='') {
                $authList = array();
            }else{
                //查询权限信息 一级
                $authList = Auth::whereIn('id',explode(',',$roleInfo['auth_ids']))
                    ->where('level',0)
                    ->get();
                foreach ($authList as $key => $value) {
                    //查询权限信息 二级
                    $s_authList = Auth::whereIn('id',explode(',',$roleInfo['auth_ids']))
                        ->where('pid',$value['id'])
                        ->where('level',1)
                        ->get();
                    if ($s_authList->isEmpty()) {
                        //没有二级权限，那么一级权限也不显示
                        unset($authList[$key]);
                    }else{
                        $authList[$key]['s_authList'] = $s_authList;
                    }
                }
            }
        }
        return view('Admin.Index.index')->with('authList',$authList)
            ->with('blogInfo',$blogInfo);
    }

    //welcome页
    public function welcome(){
        //最后登陆信息
        $lastLoginInfo = AdminLogin::orderBy('time','desc')
            ->first();
        if(getIpLookup($lastLoginInfo['ip'])){
            $lastLoginInfo['province'] = getIpLookup($lastLoginInfo['ip'])['province'];
            $lastLoginInfo['city'] = getIpLookup($lastLoginInfo['ip'])['city'];
        }else{
            $lastLoginInfo['province'] = '未知';
            $lastLoginInfo['city'] = '';
        }
        //文章数
        $articleCount = Article::count();
        //用户数
        $userCount = User::count();
        //今日注册
        $today_add = User::where('addTime','>=',strtotime(date('Y-m-d')))
            ->where('addTime','<=',strtotime("+1 day"))
            ->count();
        //今日登录
        $today_login = UserLogin::where('time','>=',strtotime(date('Y-m-d')))
            ->where('time','<=',strtotime("+1 day"))
            ->count();
        return view('Admin.Index.welcome')->with('lastLoginInfo',$lastLoginInfo)
            ->with('articleCount',$articleCount)
            ->with('userCount',$userCount)
            ->with('today_add',$today_add)
            ->with('today_login',$today_login);
    }

    //修改个人信息页面
    public function editMe(){
        $role_id = session()->get('adminInfo')['role_id'];
        $roleInfo = Role::find($role_id);
        return view('Admin.Index.editMe')->with('roleInfo',$roleInfo);
    }

    //ajax执行修改个人信息
    public function ajaxEdit(Request $request){
        $res = array(
            'state' => false,
            'echo'  => '',
            'name'  => '',
        );
        $id = $request->input('id');
        $info = Admin::where('id','!=',$id)->get();
        if($request->input('account')){
            $isAccount = 0;
            foreach ($info as $key=>$value){
                if ($request->input('account') == $value['account']){
                    $isAccount = 1;
                    break;
                }
            }
            if($isAccount == 1){
                $res['echo'] = '此登录账号已被使用';
                return response()->json($res);
            }
        }

        $adminOrm = Admin::find($id);
        $adminOrm->account = $request->input('account');
        $adminOrm->name = $request->input('name');
        $adminOrm->sex = $request->input('sex');
        $adminOrm->phone = $request->input('phone');
        $adminOrm->email = $request->input('email');
        if ($request->input('password')) {
            $adminOrm->password = md5($request->input('password'));
        }
        if ($adminOrm->save()){
            $res['state'] = true;
            $res['echo'] = '修改成功';
            $res['name'] = $request->input('name');
        }else{
            $res['echo'] = '修改失败';
        }
        return response()->json($res);
    }
}
