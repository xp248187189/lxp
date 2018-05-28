<?php

namespace App\Http\Controllers\Home;

use App\Model\User;
use App\Model\UserLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //QQ登录
    public function qqLogin(Request $request){
        //申请QQ互联后得到的APP_ID 和 APP_KEY
        $app_id = env('QQ_APP_ID');
        $app_key = env('QQ_APP_KEY');
        //回调接口，接受QQ服务器返回的信息的脚本
        $callback = env('QQ_CALL_BACK');
        //授权方法
        $scope = env('QQ_SCOPE');
        $code = $request->input('code');
        $state = $request->input('state');
        if (empty($code)){
            //没有code，那么先获取code
            // 存储来源页
            session()->put('previous',url()->previous());
            $params=array(
                'client_id'=>$app_id,
                'redirect_uri'=>$callback,
                'response_type'=>'code',
                'scope'=>$scope,
                'state'=>'yxp'
            );
            dd($params);
            $login_url = 'https://graph.qq.com/oauth2.0/authorize?'.http_build_query($params);
            header("location:$login_url");
        }else{
            // 根据code获取access-toking
            $params=array(
                'grant_type'=>'authorization_code',
                'client_id'=>$app_id,
                'client_secret'=>$app_key,
                'code'=>$code,
                'redirect_uri'=>$callback
            );
            $url='https://graph.qq.com/oauth2.0/token?'.http_build_query($params);
            $result_str = $this->http($url);
            $json_r=array();
            if($result_str!=''){
                parse_str($result_str, $json_r);
            }
            $token = $json_r['access_token'];
            // 根据access_token获取openid
            $params=array(
                'access_token'=>$token
            );
            $url='https://graph.qq.com/oauth2.0/me?'.http_build_query($params);
            $result_str=$this->http($url);
            $json_r=array();
            if($result_str!=''){
                preg_match('/callback\(\s+(.*?)\s+\)/i', $result_str, $result_a);
                $json_r=json_decode($result_a[1], true);
            }
            $openid = $json_r['openid'];
            $r = User::where('connectid','=',$openid)
                ->first();
            if (!empty($r)){
                //存在此用户
                if ($r->status==0) {
                    //禁止登录
                    $exit = '<script src="'.asset('Common').'/layui/layui.all.js"></script>';
                    $exit.= '<script src="'.asset('Common').'/layui/layuiGlobal.js"></script>';
                    $exit.= '<script type="text/javascript">';
                    $exit.= 'layer.msg("对不起，您已被限制登录！", function(){location.href="'.session()->get('previous').'"});';
                    $exit.= '</script>';
                    exit($exit);
                }else{
                    //用户已经存在，更新用户信息(避免用户修改qq昵称或者头像时，本网站不同步)
                    $params=array(
                        'oauth_consumer_key'=>$app_id,
                        'access_token'=>$token,
                        'openid'=>$openid,
                        'format'=>'json'
                    );
                    $url='https://graph.qq.com/user/get_user_info?'.http_build_query($params);
                    $result_str=$this->http($url);
                    $result=array();
                    if($result_str!=''){
                        $result=json_decode($result_str, true);
                    }
                    //将qq头像地址转为https
                    $str = substr($result['figureurl_qq_1'],0,5);
                    if ($str != 'https'){
                        $result['figureurl_qq_1'] = str_replace('http','https',$result['figureurl_qq_1']);
                    }
                    $r->account = $result['nickname'];
                    $r->sex = $result['gender'];
                    $r->head = $result['figureurl_qq_1'];
                    $r->save();
                    //存cookie
                    \Cookie::queue('user_openid',$openid,60*24*7);
                    \Cookie::queue('user_head',$result['figureurl_qq_1'],60*24*7);
                    //添加登录信息
                    $userLoginOrm = new UserLogin();
                    $userLoginOrm->ip = \Request::getClientIp();
                    $userLoginOrm->time = time();
                    $userLoginOrm->account_id = $r->id;
                    $userLoginOrm->account = '';
                    $userLoginOrm->browser = $_SERVER['HTTP_USER_AGENT'];
                    $userLoginOrm->save();
                    //返回页面
                    if (session()->get('previous') != ''){
                        return redirect(session()->get('previous'));
                    }else{
                        return redirect()->action('Home\IndexController@index');
                    }
                }
            }else{
                //用户不存在，添加用户信息
                $params=array(
                    'oauth_consumer_key'=>$app_id,
                    'access_token'=>$token,
                    'openid'=>$openid,
                    'format'=>'json'
                );
                $url='https://graph.qq.com/user/get_user_info?'.http_build_query($params);
                $result_str=$this->http($url);
                $result=array();
                if($result_str!=''){
                    $result=json_decode($result_str, true);
                }
                //将qq头像地址转为https
                $str = substr($result['figureurl_qq_1'],0,5);
                if ($str != 'https'){
                    $result['figureurl_qq_1'] = str_replace('http','https',$result['figureurl_qq_1']);
                }
                //存储用户
                $userOrm = new User();
                $userOrm->account = $result['nickname'];
                $userOrm->sex = $result['gender'];
                $userOrm->head = $result['figureurl_qq_1'];
                $userOrm->connectid = $openid;
                $userOrm->addTime = time();
                $userOrm->status = 1;
                $userOrm->save();
                //存cookie
                \Cookie::queue('user_openid',$openid,60*24*7);
                \Cookie::queue('user_head',$result['figureurl_qq_1'],60*24*7);
                //添加登录信息
                $userLoginOrm = new UserLogin();
                $userLoginOrm->ip = \Request::getClientIp();
                $userLoginOrm->time = time();
                $userLoginOrm->account_id = $userOrm->id;
                $userLoginOrm->account = '';
                $userLoginOrm->browser = $_SERVER['HTTP_USER_AGENT'];
                $userLoginOrm->save();
                //返回页面
                if (session()->get('previous') != ''){
                    return redirect(session()->get('previous'));
                }else{
                    return redirect()->action('Home\IndexController@index');
                }
            }
        }
    }

    //退出登录
    public function userLogOut(){
        \Cookie::queue('user_openid',null,-1);
        \Cookie::queue('user_head',null,-1);
        return redirect(url()->previous());
    }

    public function http($url, $postfields='', $method='GET', $headers=array()){
        $ci=curl_init();
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        if($method=='POST'){
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response=curl_exec($ci);
        curl_close($ci);
        return $response;
    }

}
