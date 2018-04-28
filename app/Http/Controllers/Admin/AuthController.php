<?php

namespace App\Http\Controllers\Admin;

use App\Model\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array(),'current'=>array('id'=>0,'name'=>'根目录','level'=>0,'id_list'=>0),'queueStr'=>'');
            //查询权限信息
            if (!\Route::input('id')){
                $whereArray[] = ['level','=',0];
            }else{
                $whereArray[] = ['pid','=',\Route::input('id')];
                //查询队列
                $current = Auth::find(\Route::input('id'));
                $return['current'] = $current;
                $return['current']['level'] = $return['current']['level']+1;
                //$queue = Auth::orderByRaw('field()')
                $queue = \DB::table('auth')->orderByRaw(\DB::raw("FIELD('id', ".$current['id_list'].')'))
                    ->whereIn('id',explode(',',$current['id_list']))
                    ->get();
                $queueStr = '';
                //因为larvel查询出来的为object，用这种方式转为数组
                $queue = json_decode(json_encode($queue), true);
                //print_r($queue);
                foreach ($queue as $key => $value) {
                    //print_r($value);
                    $queueStr .= ' <i class="fa fa-fw fa-arrow-right"></i> <a href="javascript:;" onclick="nextLevel('.$value['id'].')">'.$value['name'].'</a>';
                    $return['queueStr'] = $queueStr;
                }
            }
            if($request->input('name')){
                $whereArray[] = ['name','like','%'.$request->input('name').'%'];
            }
            $return['count'] = Auth::where($whereArray)->count();
            $return['data'] = Auth::where($whereArray)->orderBy('sort','asc')->paginate($request->input('limit'))->toArray()['data'];
            //print_r($return);
            exit(json_encode($return));
        }
        return view('Admin.Auth.showList');
    }

    //添加页
    public function add(){
        //获取图标class
        $iconClassFile = file_get_contents(asset('/Common/font-awesome/css/font-awesome.css'));
        preg_match_all('/\.(.*?):before {/',$iconClassFile,$iconInfo);
        $iconClass = $iconInfo[1];
        return view('Admin.Auth.add')->with('iconClass',$iconClass)
            ->with('pid',\Route::input('pid'))
            ->with('level',\Route::input('level'))
            ->with('id_list',\Route::input('id_list'));
    }

    //ajax执行添加
    public function ajaxAdd(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $authOrm = new Auth();
        $authOrm->controller = is_null($request->input('controller'))?'':ucfirst($request->input('controller'));
        $authOrm->action = is_null($request->input('action'))?'':$request->input('action');
        $authOrm->name = is_null($request->input('name'))?'':$request->input('name');
        $authOrm->sort = is_null($request->input('sort'))?'':$request->input('sort');
        $authOrm->icon = is_null($request->input('icon'))?'':$request->input('icon');
        $authOrm->id_list = is_null($request->input('id_list'))?'':$request->input('id_list');
        $authOrm->level = is_null($request->input('level'))?'':$request->input('level');
        $authOrm->pid = is_null($request->input('pid'))?'':$request->input('pid');
        $authOrm->save();
        $insertTd = $authOrm->id;

        $authOrmFind = Auth::find($insertTd);
        if ($request->input('id_list')==0){
            $authOrmFind->id_list = $insertTd;
        }else{
            $authOrmFind->id_list = $request->input('id_list').','.$insertTd;
        }
        $authOrmFind->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        exit(json_encode($res));
    }

    //编辑页
    public function edit(){
        $id = \Route::input('id');
        $authInfo = Auth::find($id);
        //获取图标class
        $iconClassFile = file_get_contents(asset('/Common/font-awesome/css/font-awesome.css'));
        preg_match_all('/\.(.*?):before {/',$iconClassFile,$iconInfo);
        $iconClass = $iconInfo[1];
        return view('Admin.Auth.edit')->with('iconClass',$iconClass)
            ->with('authInfo',$authInfo);
    }

    //ajax执行编辑
    public function ajaxEdit(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $id = $request->input('id');
        $authOrm = Auth::find($id);
        $authOrm->controller = is_null($request->input('controller'))?'':ucfirst($request->input('controller'));
        $authOrm->action = is_null($request->input('action'))?'':$request->input('action');
        $authOrm->name = is_null($request->input('name'))?'':$request->input('name');
        $authOrm->sort = is_null($request->input('sort'))?'':$request->input('sort');
        $authOrm->icon = is_null($request->input('icon'))?'':$request->input('icon');
        $authOrm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        exit(json_encode($res));
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $this->delAllSon($ids);
        $res['status'] = true;
        $res['echo'] = '删除成功';
        exit(json_encode($res));
    }

    //递归删除所有子级
    public function delAllSon($ids){
        $ids = trim($ids,',');
        //删除本身
        Auth::destroy(explode(',',$ids));
        //把本身ids转换为数组
        $idsArr = explode(',',$ids);
        //循环数组
        foreach ($idsArr as $key => $value) {
            //查出子级
            $r = Auth::whereIn('pid',explode(',',$value))->get();
            $r = json_decode(json_encode($r), true);
            if ($r){
                //拼接子级id
                $son_ids = '';
                foreach ($r as $k => $v) {
                    $son_ids .= $v['id'].',';
                }
                $this->delAllSon($son_ids);
            }
        }
    }
}
