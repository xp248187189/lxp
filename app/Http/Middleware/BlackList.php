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
        $blackArr = Cache::remember('home_blackList',10,function (){
            return \App\Model\BlackList::where('status','=','1')->pluck('ip')->toArray();
        });
        $ip = \Request::getClientIp();
        if (!empty($blackArr) && in_array($ip,$blackArr)){
            abort(403);
        }
        Cache::remember('about_cache',60,function (){
            $info = About::find(1);
            $info->name = getQQName('248187189');
            $info->img = getQQHeadPortrait('248187189');
            $info->save();
            return About::get();
        });
        return $next($request);
    }
}
