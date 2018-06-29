<?php

namespace App\Http\Middleware;

use App\Model\About;
use Closure;
use Illuminate\Support\Facades\Cache;

class BlackList
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $blackList = \App\Model\BlackList::where('status','=','1')->get();
        $ip = \Request::getClientIp();
        $is_in = false;
        foreach ($blackList as $key => $value){
            if ($ip == $value->ip){
                $is_in = true;
                break;
            }
        }
        if ($is_in){
            $echo = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible"content="IE=edge"><meta name="viewport"content="width=device-width, initial-scale=1"><title>这个..页面出错了！！！</title><!--Fonts--><link href="https://fonts.googleapis.com/css?family=Raleway:100,600"rel="stylesheet"type="text/css"><!--Styles--><style>html,body{background-color:#fff;color:#636b6f;font-family:\'Raleway\',sans-serif;font-weight:100;height:100vh;margin:0}.full-height{height:100vh}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.content{text-align:center}.title{font-size:36px;padding:20px}</style></head><body><div class="flex-center position-ref full-height"><div class="content"><div class="title">(●′ω`●) 对不起... 您无权访问此页面！！！</div></div></div></body></html>';
            exit($echo);
        }
        Cache::add('about_cache',About::get(),60);
        return $next($request);
    }
}
