<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Model\AdminLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

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
        //二次验证token
        $checkTokenParam = [
            'id' => config('api.vaptcha_vid'),
            'secretkey' => config('api.vaptcha_key'),
            'scene' => 0,
            'token' => $request->input('token'),
            'ip' => \Request::getClientIp(),
        ];
        $api_return_key_val = [
            'id-empty' => 'id为空',
            'id-error' => 'id错误',
            'scene-error' => '场景号错误',
            'token-error' => 'token错误，请重新验证',
            'token-expired' => 'token过期，请重新验证',
            'over-user-limit' => '超过VIP用户自定义的频率上限',
            'bad-request' => '请求错误',
        ];
        $api_res = curl('http://0.vaptcha.com/verify',$checkTokenParam,true,true);
        $api_res = json_decode($api_res,true);
        if ($api_res['success'] == 0){
            $res['echo'] = isset($api_return_key_val[$api_res['msg']]) ? $api_return_key_val[$api_res['msg']] : '未知错误';
            return $res;
        }
        //查询
        $adminInfo = Admin::where('account',$request->input('account'))->first();
        //判断是否存在此管理员账号
        if (empty($adminInfo)) {
            $res['echo'] = '用户名或密码错误';
            return $res;
        }
        //判断账号是否禁用
        if ($adminInfo->status==0) {
            $res['echo'] = '此账号已被禁用';
            return $res;
        }
        //判断密码是否正确
        if (!Hash::check($request->input('password'),$adminInfo->password)){
            $res['echo'] = '用户名或密码错误';
            return $res;
        }
        if($request->input('online')==1){
            \Cookie::queue('admin_id',$adminInfo['id'],60*24*7);
        }else{
            \Cookie::queue('admin_id',$adminInfo['id']);
        }
        \Cookie::queue('lockViewPass',$adminInfo['password'],60*24*7);
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
        return response()->json($res);
    }
    /**
     * 退出登录
     */
    public function doLogOut(){
        session()->forget('adminInfo');
        \Cookie::queue('admin_id',null,-1);
        \Cookie::queue('lockViewPass',null,-1);
        return response()->json(array('status'=>true,'echo'=>'退出成功'));
    }
}
