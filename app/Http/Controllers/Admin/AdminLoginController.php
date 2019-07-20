<?php

namespace App\Http\Controllers\Admin;

use App\Model\AdminLogin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action') == 'getData'){
            //设置条件
            $where   = [];
            $orWhere = [];
            if ($request->filled('startTime')){
                $startTime = $request->input('startTime') . ' 00:00:00';
                $where[]   = ['time', '>=', strtotime($startTime)];
            }
            if ($request->filled('endTime')){
                $endTime = $request->input('endTime') . ' 23:59:59';
                $where[] = ['time', '<=', strtotime($endTime)];
            }
            if ($request->filled('keyWord')){
                $orWhere[] = ['ip'     , 'like', '%' . $request->input('keyWord') . '%'];
                $orWhere[] = ['account', 'like', '%' . $request->input('keyWord') . '%'];
            }
            //根据条件查询数据
            $data = AdminLogin::where($where)
                ->where(function ($query) use ($orWhere){
                    foreach ($orWhere as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->orderBy('time','desc')
                ->paginate($request->input('limit'))
                ->toArray();
            //返回数据
            return ['code'=>0,'msg'=>'','count'=>$data['total'],'data'=>$data['data']];
        }
        return view('Admin.AdminLogin.showList');
    }

    //删除
    public function ajaxDel(Request $request){
        $ids = $request->input('id');
        $ids = trim($ids,',');
        AdminLogin::destroy(explode(',',$ids));
        return ['status' => true, 'echo' => '删除成功'];
    }
}
