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
        $blackList = Cache::remember('home_blackList',10,function (){
            return \App\Model\BlackList::where('status','=','1')->get();
        });
        $ip = \Request::getClientIp();
        $is_in = false;
        foreach ($blackList as $key => $value){
            if ($ip == $value->ip){
                $is_in = true;
                break;
            }
        }
        if ($is_in){
            abort(403);
        }
        Cache::add('about_cache',About::get(),60);
        return $next($request);
    }
}
