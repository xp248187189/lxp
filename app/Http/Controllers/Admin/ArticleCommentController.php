<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\ArticleComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCommentController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            $orWhereArray = array();
            if ($request->input('startTime')){
                $whereArray[] = ['time','>=',strtotime($request->input('startTime'))];
            }
            if ($request->input('endTime')){
                $whereArray[] = ['time','<=',strtotime($request->input('endTime'))+86400];
            }
            if ($request->input('keyWord')){
                $orWhereArray[] = ['article_name','like','%'.$request->input('keyWord').'%'];
                $orWhereArray[] = ['user_account','like','%'.$request->input('keyWord').'%'];
            }
            $return['count'] = ArticleComment::where($whereArray)
                ->where(function ($query) use ($orWhereArray){
                    foreach ($orWhereArray as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->count();
            $return['data'] = ArticleComment::where($whereArray)
                ->where(function ($query) use ($orWhereArray){
                    foreach ($orWhereArray as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->orderBy('time','desc')
                ->paginate($request->input('limit'))
                ->toArray()['data'];
            return $return;
        }
        return view('Admin.ArticleComment.showList');
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $ids = trim($ids,',');
        $articleIds = ArticleComment::whereIn('id',explode(',',$ids))->get();
        ArticleComment::destroy(explode(',',$ids));
        $articleIdArr = [];
        foreach ($articleIds as $key => $value){
            $articleIdArr[] = $value->article_id;
        }
        $articleIdArr = array_unique($articleIdArr);
        foreach ($articleIdArr as $key => $value){
            $commentCount = ArticleComment::where('article_id','=',$value)->count();
            $articleOrm = Article::find($value);
            $articleOrm->commentCount = $commentCount;
            $articleOrm->save();
        }
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
