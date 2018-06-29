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
        //归档列表
        $list = Cache::remember(sha1($request->fullUrl().'_jokeList_cache'),15,function (){
            return json_decode(curl('http://v.juhe.cn/joke/randJoke.php',['key'=>config('juheApi.juhe_key')]));
        });
        return view('Home.Joke.joke')->with('jokeList',$list->result)
            ->with('controllerName','Joke');
    }
}
