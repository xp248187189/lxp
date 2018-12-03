<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Cache;
use App\Model\BingImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BingImgController extends Controller
{
    public function atlas(Request $request){
        $data = Cache::remember(sha1($request->fullUrl().'_atlas_cache'),1,function (){
            return BingImg::orderBy('date','desc')
                ->paginate(20,['*'],'p');
        });
        if ($data->isEmpty()){
            return redirect('/atlas');
        }
        return view('Home.BingImg.atlas')->with('data',$data);
    }
}
