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
        $data = Cache::remember(sha1($request->fullUrl()),20,function (){
            //笑话列表
            $list = json_decode(curl('http://v.juhe.cn/joke/randJoke.php',['key'=>config('api.juhe_key')]));
            //历史上的今天
            $todayonhistory = json_decode(curl('https://www.ipip5.com/today/api.php',['type'=>'json'],false,true));
            $data = new \stdClass();
            $data->jokeList = $list->result;
            $data->todayonhistory = $todayonhistory;
            return $data;
        });
        return view('Home.Joke.joke')->with('data',$data);
    }
}
