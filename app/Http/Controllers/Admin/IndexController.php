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
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    //首页面
    public function index(){
        //博客信息
        $blogInfo = About::find(2);
        //判断是否是超级管理员
        if (session()->get('adminInfo')['id'] ==1){
            //查询权限信息 一级
            $authList = Auth::where('level',0)
                ->orderBy('sort','asc')
                ->get()
                ->toArray();
            //查询权限信息 二级
            $s_authList = Auth::where('level',1)
                ->orderBy('sort','asc')
                ->get()
                ->toArray();
        }else{
            //查询角色信息
            $roleInfo = Role::find(session()->get('adminInfo')['role_id']);
            if ($roleInfo['auth_ids']=='') {
                $authList = array();
            }else{
                //查询权限信息 一级
                $authList = Auth::whereIn('id',explode(',',$roleInfo['auth_ids']))
                    ->where('level',0)
                    ->orderBy('sort','asc')
                    ->get()
                    ->toArray();
                //查询权限信息 二级
                $s_authList = Auth::whereIn('id',explode(',',$roleInfo['auth_ids']))
                    ->where('level',1)
                    ->orderBy('sort','asc')
                    ->get()
                    ->toArray();
            }
        }
        //组合数据
        foreach ($authList as $k => $v){
            foreach ($s_authList as $kk => $vv){
                if ($vv['pid'] == $v['id']){
                    $authList[$k]['s_authList'][] = $vv;
                }
            }
            //没有二级权限，那么一级权限也不显示
            if (!array_key_exists('s_authList',$authList[$k]) || empty($authList[$k]['s_authList'])){
                unset($authList[$k]);
            }
        }
        //判断是否锁屏
        $isLockView = $this->checkIsLockView()['isLockView'];
        return view('Admin.Index.index')->with('authList',$authList)
            ->with('blogInfo',$blogInfo)
            ->with('isLockView',$isLockView);
    }

    //welcome页
    public function welcome(){
        //最后登陆信息
        $lastLoginInfo = AdminLogin::where('account_id','=',session()->get('adminInfo')['id'])
            ->orderBy('time','desc')
            ->take(2)
            ->get();
        if ($lastLoginInfo->count()==2){
            if(getIpLookup($lastLoginInfo[1]->ip)){
                $lastLoginInfo[1]->province = getIpLookup($lastLoginInfo[1]->ip)->content->address_detail->province;
                $lastLoginInfo[1]->city = getIpLookup($lastLoginInfo[1]->ip)->content->address_detail->city;
            }else{
                $lastLoginInfo[1]->province = '未知';
                $lastLoginInfo[1]->city = '';
            }
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
            'status' => false,
            'echo'  => '',
            'name'  => '',
        );
        $id = $request->input('id');
        $info = Admin::where('id','!=',$id)->get();
        if($request->input('account')){
            $isAccount = 0;
            foreach ($info as $key=>$value){
                if ($request->input('account') == $value->account){
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
            $res['status'] = true;
            $res['echo'] = '修改成功';
            $res['name'] = $request->input('name');
            \Cookie::queue('lockViewPass',md5($request->input('password')),60*24*7);
        }else{
            $res['echo'] = '修改失败';
        }
        return response()->json($res);
    }

    //查看phpinfo
    public function showPhpInfo(){
        if (session()->get('adminInfo')['id'] !=1){
            abort(404);
        }
        phpinfo();
    }

    //清空缓存
    public function cacheFlush(){
        Cache::flush();
        return ['status' => true,'echo'  => '清空成功'];
    }

    //验证密码 -- 锁屏
    public function checkPassWord(Request $request){
        $data = [
            'echo' => '验证错误',
            'status' => false
        ];
        if($request->ajax()){
            if (md5($request->input('passWord')) === session()->get('adminInfo')['password']){
                $data['echo'] = '验证正确';
                $data['status'] = true;
                \Cookie::queue('lockViewPass',session()->get('adminInfo')['password'],60*24*7);
            }
            return $data;
        }
        return $data;
    }

    // 锁屏
    public function lockView(){
        \Cookie::queue('lockViewPass',str_random(),60*24*7);
        $data = [
            'echo' => '成功',
            'status' => true
        ];
        return $data;
    }

    // 判断是否锁定
    public function checkIsLockView(){
        //判断是否锁屏
        $isLockView = 1;
        if(\Cookie::get('lockViewPass') == session()->get('adminInfo')['password']){
            $isLockView = 0;
        }
        return ['status'=>true,'echo'=>'成功','isLockView'=>$isLockView];
    }
}
