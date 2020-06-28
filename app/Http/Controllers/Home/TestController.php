<?php
namespace App\Http\Controllers\Home;

class TestController extends Controller{
  public function test(Request $request){
    return ['status'=>true,'echo'=>'成功'];
  }
}
