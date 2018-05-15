<?php

namespace App\Http\Middleware;

use App\Model\VisitUrl;
use Closure;

class RecordUrl
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
        $visitUrlOrm = new VisitUrl();
        $visitUrlOrm->ip = \Request::getClientIp();
        $visitUrlOrm->url = url()->current();
        $visitUrlOrm->save();
        // dd(123);
        return $next($request);
    }
}
