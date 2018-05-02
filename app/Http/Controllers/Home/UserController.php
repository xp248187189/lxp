<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //QQ登录
    public function qqLogin(Request $request){
        //申请QQ互联后得到的APP_ID 和 APP_KEY
        $app_id = 101449564;
        $app_key = 'f9d96c8edcea2f32f2f7c27875e43b5c';
        //回调接口，接受QQ服务器返回的信息的脚本
        $callback = 'http://www.yxiupei.cn/qqLogin';
        //授权方法
        $scope='get_user_info';
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
            //获取openid
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
            var_dump($json_r);
        }



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
