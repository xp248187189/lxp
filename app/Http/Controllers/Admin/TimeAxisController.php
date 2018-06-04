<?php

namespace App\Http\Controllers\Admin;

use App\Model\TimeAxis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeAxisController extends Controller
{
    //列表
    public function showList(Request $request){
        if(\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('startTime')){
                $whereArray[] = ['time','>=',strtotime($request->input('startTime'))];
            }
            if ($request->input('endTime')){
                $whereArray[] = ['time','<=',strtotime($request->input('endTime'))+86400];
            }
            $data = TimeAxis::where($whereArray)
                ->orderBy('year','desc')
                ->orderBy('month','desc')
                ->orderBy('day','desc')
                ->orderBy('hour','desc')
                ->orderBy('minute','desc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.TimeAxis.showList');
    }

    //添加页
    public function add(){
        return view('Admin.TimeAxis.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $orm = new TimeAxis();
        if ($request->input('content')){
            $orm->content = $request->input('content');
        }else{
            $orm->content = '';
        }
        $orm->status = $request->status;
        $orm->isHome = $request->isHome;
        $orm->year = date('Y');
        $orm->month = date('m');
        $orm->day = date('d');
        $orm->hour = date('H');
        $orm->minute = date('i');
        $orm->time = time();
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $TimeAxisInfo = TimeAxis::find($id);
        return view('Admin.TimeAxis.edit')->with('TimeAxisInfo',$TimeAxisInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $orm = TimeAxis::find($id);
        if ($request->input('status') !== null){
            $orm->status = $request->input('status');
        }
        if ($request->input('isHome') !== null){
            $orm->isHome = $request->input('isHome');
        }
        if ($request->input('content')){
            $orm->content = $request->input('content');
        }
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $ids = trim($ids,',');
        TimeAxis::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
