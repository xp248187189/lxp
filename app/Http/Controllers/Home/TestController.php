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
    system('/home/wwwroot/lxp/app/Http/Controllers/Home/git_ychat_pull.sh');
  }
}
