<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            if ($request->input('name')) {
                $whereArray[] = ['name','like','%'.$request->input('name').'%'];
            }
            $data = Category::where($whereArray)
                ->orderBy('sort','asc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.Category.showList');
    }

    //添加页
    public function add(){
        return view('Admin.Category.add');
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $categoryOrm = new Category();
        $categoryOrm->name = $request->input('name');
        $categoryOrm->sort = $request->input('sort');
        $categoryOrm->status = $request->input('status');
        $categoryOrm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $CategoryInfo = Category::find($id);
        return view('Admin.Category.edit')->with('CategoryInfo',$CategoryInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $categoryOrm = Category::find($id);
        if ($request->input('name')){
            $categoryOrm->name = $request->input('name');
        }
        if ($request->input('sort')){
            $categoryOrm->sort = $request->input('sort');
        }
        if ($request->input('status') !== null){
            $categoryOrm->status = $request->input('status');
        }
        $categoryOrm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }

    //删除 - 不可批量删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        //$ids = trim($ids,',');
        //Category::destroy(explode(',',$ids));
        $articles = Article::where('category_id',$ids)->get();
        if ($articles->isEmpty()){
            Category::where('id',$ids)->delete();
            $res['status'] = true;
            $res['echo'] = '删除成功';
        }else{
            $res['status'] = false;
            $res['echo'] = '有 '.$articles->count().' 篇文章属于此分类，无法删除';
        }
        return $res;
    }
}
