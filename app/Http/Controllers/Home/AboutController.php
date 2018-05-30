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
        //关于博客
        $blogInfo = Cache::remember(sha1($request->fullUrl().'_blogInfo_cache'),10,function (){
            return About::find(2);
        });
        //关于博主
        $bloggerInfo = Cache::remember(sha1($request->fullUrl().'_bloggerInfo_cache'),10,function (){
            return About::find(1);
        });
        //关键字
        $keyWordsInfo = Cache::remember(sha1($request->fullUrl().'_keyWordsInfo_cache'),10,function (){
            return About::find(3);
        });
        //描述
        $descriptionInfo = Cache::remember(sha1($request->fullUrl().'_descriptionInfo_cache'),10,function (){
            return About::find(4);
        });
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
        $userComment = UserComment::orderBy('time','desc')
            ->where('pid','=','0')
            ->paginate(8)
            ->toArray();
        $pageCount = $userComment['last_page'];
        $newList = $userComment['data'];
        foreach ($newList as $key => $value){
            $newList[$key]['son'] = UserComment::where('pid','=',$value['id'])->orderBy('time','asc')->get()->toArray();
        }
        return ['data'=>$newList,'pageCount'=>$pageCount];
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
