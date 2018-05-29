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

class AboutController extends Controller
{
    public function about(){
        //网站推荐
        $linkList = Link::where('status','=','1')
            ->orderBy('sort','asc')
            ->get();
        //关于博客
        $blogInfo = About::find(2);
        //关于博主
        $bloggerInfo = About::find(1);
        //关键字
        $keyWordsInfo = About::find(3);
        //描述
        $descriptionInfo = About::find(4);
        //判断是否登录
        if(\Cookie::has('user_openid')){
            $isLogin = true;
        }else{
            $isLogin = false;
        }
        return view('Home.About.about')->with('linkList',$linkList)
            ->with('blogInfo',$blogInfo)
            ->with('keyWordsInfo',$keyWordsInfo)
            ->with('descriptionInfo',$descriptionInfo)
            ->with('bloggerInfo',$bloggerInfo)
            ->with('controllerName','About')
            ->with('isLogin',$isLogin);
    }

    //获取留言
    public function getUserComment(){
        $count = UserComment::count();
        $pageCount = ceil($count/8);
        $userComment = UserComment::orderBy('time','desc')
            ->paginate(8)
            ->toArray()['data'];
        $parentList = [];
        $sonList = [];
        foreach ($userComment as $key => $value){
            if ($value['pid'] == 0){
                $parentList[] = $value;
            }else{
                $sonList[] = $value;
            }
        }
        $sonList = arraySequence($sonList,'time','SORT_ASC');
        foreach ($parentList as $k => $v){
            $parentList[$k]['son'] = [];
            foreach ($sonList as $kk => $vv){
                if ($v['id'] == $vv['pid']){
                    $parentList[$k]['son'][] = $vv;
                }
            }
        }
        $userComment = $parentList;
        return ['data'=>$userComment,'pageCount'=>$pageCount];
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
