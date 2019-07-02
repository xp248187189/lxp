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
        $orm->img = $request->input('img');
        // if ($request->file('img')){
            // @unlink(public_path('uploads/').$orm->img);
            // $path = $request->file('img')->store('about/'.date('Y-m-d'),'myUploads');
            // $orm->img = $path;
            // $requestImg = $request->file('img');
            // $fileName = md5(time().str_random()).'.'.$requestImg->getClientOriginalExtension();
            // $path = public_path('uploads/about/'.date('Y-m-d').'/'.$fileName);
            // $requestImgRealPath = $requestImg->getRealPath();
            // \Image::make($requestImgRealPath)->insert(public_path('watermarkImg/watermark.png'),'bottom-right', 15, 10)->save($path);
            // $orm->img = 'about/'.date('Y-m-d').'/'.$fileName;
        // }
        $orm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }
}
