<?php

namespace App\Http\Controllers\Home;

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
        exit(json_encode(array('data'=>$userComment,'pageCount'=>$pageCount)));
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
        $userCommentOrm->save();
        exit(json_encode(array('status'=>true,'echo'=>'评论成功')));
    }
}
