<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Model\AdminLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function login(){
        return view('Admin.Login.login');
    }
    /**
     * ajax执行登陆
     */
    public function doLogin(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        //手动验证
        $validator = \Validator::make($request->all(),[
            //定义验证规则
            'verify' => 'required|captcha'
        ],[
            //自定义规则说明
            'required' => '必填',
            'captcha' => '验证码错误',
        ],[
            //自定义字段说明
            'verify' => '验证码',
        ]);
        //判断验证是否成功
        if ($validator->fails()){
            $errors = $validator->errors();
            $res['echo'] = $errors->first();
            return json_encode($res);
        }
        //查询
        //$postAccount = $request->input('account');
        $adminInfo = Admin::where('account',$request->input('account'))->first();
        //判断是否存在此管理员账号
        if (empty($adminInfo)) {
            $res['echo'] = '用户名或密码错误';
            exit(json_encode($res));
        }
        //判断账号是否禁用
        if ($adminInfo['status']==0) {
            $res['echo'] = '此账号已被禁用';
            exit(json_encode($res));
        }
        //判断密码是否正确
        if($adminInfo['password'] != md5($request->input('password'))){
            $res['echo'] = '用户名或密码错误';
            exit(json_encode($res));
        }
        // exit($request->input('online'));
        if($request->input('online')==1){
            \Cookie::queue('admin_id',$adminInfo['id'],60*24*7);
        }else{
            \Cookie::queue('admin_id',$adminInfo['id']);
        }
        //添加登陆信息
        $adminLoginOrm = new AdminLogin();
        $adminLoginOrm->ip = \Request::getClientIp();
        $adminLoginOrm->time = time();
        $adminLoginOrm->account_id = $adminInfo['id'];
        $adminLoginOrm->account = $adminInfo['account'];
        $adminLoginOrm->browser = $_SERVER['HTTP_USER_AGENT'];
        $adminLoginOrm->save();
        $res['status'] = true;
        $res['echo'] = '登录成功';
        //exit(json_encode($res));
        return response()->json($res);
    }
    /**
     * 退出登录
     */
    public function doLogOut(){
        session()->forget('adminInfo');
        \Cookie::queue('admin_id',null,-1);
        return response()->json(array('status'=>true,'echo'=>'退出成功'));
    }
}
