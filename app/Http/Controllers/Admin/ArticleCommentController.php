<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\ArticleComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
            $data = ArticleComment::where($whereArray)
                ->where(function ($query) use ($orWhereArray){
                    foreach ($orWhereArray as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->orderBy('time','desc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
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
        //查询文章id
        $articleIds = ArticleComment::whereIn('id',explode(',',$ids))->get();
        //删除评论
        ArticleComment::destroy(explode(',',$ids));
        //组装文章id
        $articleIdArr = [];
        foreach ($articleIds as $key => $value){
            $articleIdArr[] = $value->article_id;
        }
        //数组去重，并让下标重0开始
        $articleIdArr = array_values(array_unique($articleIdArr));
        //查询包含此文章id的评论
        $articleComment = ArticleComment::whereIn('article_id',$articleIdArr)->get();
        //组装数组，键为文章id，值为评论数
        $newList = [];
        foreach ($articleIdArr as $k => $v){
            $newList[$v] = 0;
            foreach ($articleComment as $kk => $vv){
                if ($v == $vv->article_id){
                    $newList[$v] ++;
                }
            }
        }
        //组装 case when 语句
        $update_value = '';
        foreach ($newList as $key => $value){
            $update_value .= ' when '.$key.' then '.$value;
        }
        $update_value = 'case id'.$update_value.' end';
        //执行操作
        // DB::table('article')->whereIn('id',$articleIdArr)->update(['commentCount'=>$update_value]);
        $sql = 'update `lxp_article` set `commentCount` = '.$update_value.' where id in('.implode(',',$articleIdArr).')';
        DB::update($sql);
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }
}
