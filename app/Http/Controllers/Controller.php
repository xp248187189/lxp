<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //请求方式
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http';
        if ($http_type == 'http'){
            $length = 7;
        }else{
            $length = 8;
        }
        $current_url = url()->full();
        $str = substr($current_url,$length,3);
        if ($str != 'www'){
            $url_arr = explode('://',$current_url);
            $url = $http_type.'://www.'.$url_arr[1];
            $this->middleware(function() use ($url){
                return redirect($url,301);
            });
        }
    }
}
