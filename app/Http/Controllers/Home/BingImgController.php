<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\Cache;
use App\Model\BingImg;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BingImgController extends Controller
{
    public function atlas(Request $request){
        if (\Route::input('action') == 'getData'){
            if ($request->ajax()) {
                $data = Cache::remember(sha1($request->fullUrl() . '_atlas_cache'), 10, function () {
                    return BingImg::orderBy('date', 'desc')
                        ->paginate(20, ['*'], 'page')
                        ->toArray();
                });
                $returnData = [
                    'data' => $data['data'],
                    'pages' => $data['last_page']
                ];
                return $returnData;
            }else{
                abort(403);
            }
        }
        return view('Home.BingImg.atlas');
    }
}
