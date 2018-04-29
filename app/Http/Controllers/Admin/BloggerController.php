<?php

namespace App\Http\Controllers\Admin;

use App\Model\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BloggerController extends Controller
{
    //显示
    public function show(){
        $info = About::find(1);
        return view('Admin.Blogger.show')->with('info',$info);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $orm = About::find(1);
        $orm->name = $request->input('name');
        $orm->label = $request->input('label');
        $orm->introduce = $request->input('introduce');
        $orm->detail = $request->input('detail');
        if ($request->file('img')){
            @unlink(public_path('uploads/').$orm->img);
            $path = $request->file('img')->store('about/'.date('Y-m-d'),'myUploads');
            $orm->img = $path;
        }
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        exit(json_encode($res));
    }
}
