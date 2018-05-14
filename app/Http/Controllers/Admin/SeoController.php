<?php

namespace App\Http\Controllers\Admin;

use App\Model\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{
    //显示
    public function show(){
        $keywords_info = About::find(3);
        $description_info = About::find(4);
        return view('Admin.Seo.show')->with('keywords_info',$keywords_info)
            ->with('description_info',$description_info);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $keywords_orm = About::find(3);
        $keywords_orm->label = $request->input('label_1');
        $keywords_orm->save();
        $description_orm = About::find(4);
        $description_orm->label = $request->input('label_2');
        $description_orm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }
}
