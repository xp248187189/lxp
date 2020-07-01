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

class TestController extends Controller{
  public function test(Request $request){
    $res = system('whoami 2>&1',$return_status);
    var_dump($res,$return_status);
  }
}
