<?php

namespace App\Http\Controllers\Home;

use Carbon\Carbon;
use App\Jobs\CountArticleComment;
use App\Model\User;
use App\Model\About;
use App\Model\Link;
use App\Model\UserComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function about(Request $request){
        //网站推荐
        $linkList = Cache::remember(sha1($request->fullUrl().'_linkList_cache'),10,function (){
            return Link::where('status','=','1')
                ->orderBy('sort','asc')
                ->get();
        });
        //判断是否登录
        if(\Cookie::has('user_openid')){
            $isLogin = true;
        }else{
            $isLogin = false;
        }
        //查询父级留言
        $userComment = UserComment::orderBy('time','desc')
            ->where('pid','=','0')
            ->paginate(8,['*'],'p');
        //父级数据
        $userCommentArr = $userComment->toArray()['data'];
        //查询子集留言
        $sonComment = UserComment::orderBy('time','asc')
            ->where('pid','>','0')
            ->get()
            ->toArray();
        //组合
        foreach ($userCommentArr as $k => $v){
            $userCommentArr[$k]['son'] = [];
            foreach ($sonComment as $kk => $vv){
                if ($v['id'] == $vv['pid']){
                    $userCommentArr[$k]['son'][] = $vv;
                }
            }
        }
        return view('Home.About.about')->with('linkList',$linkList)
            ->with('userComment',$userComment)
            ->with('userCommentArr',$userCommentArr)
            ->with('isLogin',$isLogin);
    }

    //提交留言
    public function userComment(Request $request){
        $openid = \Cookie::get('user_openid');
        $userInfo = User::where('connectid','=',$openid)->first();
        $userCommentOrm = new UserComment();
        $userCommentOrm->user_id = $userInfo->id;
        $userCommentOrm->user_account = '';
        $userCommentOrm->user_head = '';
        $userCommentOrm->time = time();
        $userCommentOrm->connect = $request->input('editorContent');
        if ($request->input('pid')){
            $userCommentOrm->pid = $request->input('pid');
            $pid = $request->input('pid');
        }else{
            $userCommentOrm->pid = 0;
            $pid = 0;
        }
        $userCommentOrm->save();
        if ($pid){
            //用队列修改回复数
            CountArticleComment::dispatch($pid,2)->onQueue('countArticleComment');
        }
        return ['status'=>true,'echo'=>'评论成功'];
    }
}
