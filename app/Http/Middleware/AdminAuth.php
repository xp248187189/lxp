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
                $isPass = 0;
                foreach ($authList as $item) {
                    if($item['controller'] == $endArr[0] && $item['action'] == $endArr[1]){
                        $isPass = 1;
                        break;
                    }
                }
                //如果没有控制器的权限，或者没有方法的权限，就提示错误信息
                if($isPass == 0){
                    if($request->ajax()){
                        return response(['status'=>false,'echo'=>'对不起！您暂时无权访问此页面，请稍后再试！'],403)->header('Content-Type', 'application/json');
                    }else{
                        abort(403,'form_admin');
                    }
                }
            }
        }
        return $next($request);
    }
}
