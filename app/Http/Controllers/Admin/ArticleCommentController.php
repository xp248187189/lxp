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
        if (\Route::input('action') == 'getData'){
            //设置条件
            $where   = array();
            $orWhere = array();
            if ($request->filled('startTime')){
                $startTime = $request->input('startTime') . ' 00:00:00';
                $where[]   = ['time', '>=', strtotime($startTime)];
            }
            if ($request->filled('endTime')){
                $endTime = $request->input('endTime') . ' 23:59:59';
                $where[] = ['time', '<=', strtotime($endTime)];
            }
            if ($request->filled('keyWord')){
                $orWhere[] = ['article_name', 'like', '%' . $request->input('keyWord') . '%'];
                $orWhere[] = ['user_account', 'like', '%' . $request->input('keyWord') . '%'];
            }
            //根据条件查询数据
            $data = ArticleComment::where($where)
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
        return view('Admin.ArticleComment.showList');
    }

    //删除
    public function ajaxDel(Request $request){
        DB::transaction(function () use ($request){
            $ids = $request->input('id');
            $id_arr = explode(',',trim($ids,','));
            //查询文章id
            $articleIds = ArticleComment::whereIn('id',$id_arr)->distinct()->pluck('article_id')->toArray();
            //删除评论
            ArticleComment::destroy($id_arr);
            //查询包含此文章id的评论
            $articleComment = ArticleComment::whereIn('article_id',$articleIds)
                ->groupBy('article_id')
                ->selectRaw('count(*) c,article_id')
                ->get();
            //组装数组，键为文章id，值为评论数
            $newList = [];
            $selectArticleIds = [];
            foreach ($articleComment as $k => $v){
                $newList[$v->article_id] = $v->c;
                $selectArticleIds[] = $v->article_id;
            }
            //补全不存在的
            $no = array_diff($articleIds,$selectArticleIds);
            foreach ($no as $k => $v){
                $newList[$v] = 0;
            }
            //组装 case when 语句
            $update_value = '';
            foreach ($newList as $key => $value){
                $update_value .= ' when '.$key.' then '.$value;
            }
            $update_value = 'case id'.$update_value.' end';
            //执行操作
            $sql = 'update `lxp_article` set `commentCount` = '.$update_value.' where id in('.implode(',',$articleIds).')';
            DB::update($sql);
        });
        return ['status' => true, 'echo' => '删除成功'];
    }
}
