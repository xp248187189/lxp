<?php

namespace App\Http\Middleware;

use App\Model\Admin;
use App\Model\Auth;
use App\Model\Role;
use Closure;

class AdminAuth
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
        //判断是否登录
        if(!\Cookie::get('admin_id')){
            return redirect('/login');
        }
        //已登录，每次执行操作都进行查询登录人信息并赋值给$_SESSION['adminInfo']
        $adminOrm = new Admin();
        $adminInfo = $adminOrm->find(\Cookie::get('admin_id'));
        session()->put('adminInfo',$adminInfo->toarray());
        //如果不是超级管理员，就需要进行权限判断
        if (session()->get('adminInfo')['id'] !=1){
            //查询角色信息，根据角色查询对应的权限
            $roleInfo = Role::find(session()->get('adminInfo')['role_id']);
            if ($roleInfo['auth_ids']=='') {
                $roleInfo['auth_ids'] = 0;
            }
            //权限列表
            $authList = Auth::whereIn('id',explode(',',$roleInfo['auth_ids']))->get();
            //获取当前路由 格式:App\Http\Controllers\Admin\IndexController@index
            $actionName = \Route::getCurrentRoute()->getActionName();
            $actionNameArr = explode('\\',$actionName);
            //获取控制器及方法 格式:IndexController@index
            $end = end($actionNameArr);
            $endArr = explode('@',$end);
            $endArr[0] = substr($endArr[0],0,-10);
            //Index控制器不设置权限
            if($endArr[0] != 'Index'){
                $authListArr = $authList->toArray();
                $c = 0;
                $a = 0;
                foreach ($authList as $item) {
                    if($item['controller'] == $endArr[0]){
                        $c = 1;
                        break;
                    }
                }
                foreach ($authList as $item) {
                    if($item['action'] == $endArr[1]){
                        $a = 1;
                        break;
                    }
                }
                //如果没有控制器的权限，或者没有方法的权限，就提示错误信息
                if($c ==0 || $a == 0){
                    if($request->ajax()){
                        return response()->json(array('status'=>false,'echo'=>'(●′ω`●) 对不起... 您无权进行此操作！！！'));
                    }else{
                        $echo = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>这个..页面出错了！！！</title><!--Styles--><style>html,body{background-color:#fff;color:#636b6f;font-family:\'Raleway\',sans-serif;font-weight:100;height:100vh;margin:0}.full-height{height:100vh}.flex-center{align-items:center;display:flex;justify-content:center}.position-ref{position:relative}.content{text-align:center}.title{font-size:36px;padding:20px}</style></head><body><div class="flex-center position-ref full-height"><div class="content"><div class="title">(●′ω`●) 对不起... 您无权访问此页面！！！</div></div></div></body></html>';
                        exit($echo);
                    }
                }
            }
        }
        return $next($request);
    }
}
