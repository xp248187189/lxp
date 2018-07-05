<?php

namespace App\Http\Controllers\Home;

use App\Model\About;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class JokeController extends Controller
{
    public function joke(Request $request){
        //笑话列表
        $list = Cache::remember(sha1($request->fullUrl().'_jokeList_cache'),15,function (){
            return json_decode(curl('http://v.juhe.cn/joke/randJoke.php',['key'=>config('juheApi.juhe_key')]));
        });
        //历史上的今天
        $todayonhistory = Cache::remember(sha1($request->fullUrl().'_todayonhistory_cache'),15,function (){
            return json_decode(curl('https://www.ipip5.com/today/api.php',['type'=>'json'],false,true));
        });
        return view('Home.Joke.joke')->with('jokeList',$list->result)->with('todayonhistory',$todayonhistory);
    }
}
