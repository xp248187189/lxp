<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\ArticleComment;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //列表
    public function showList(Request $request){
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArr = [];
            if ($request->input('keyWord')){
                $whereArr[] = ['title','like','%'.$request->input('keyWord').'%'];
            }
            if ($request->input('category_id')){
                $whereArr[] = ['category_id','=',$request->input('category_id')];
            }
            $data = Article::where($whereArr)
                ->orderBy('sort','asc')
                ->orderBy('created_at','desc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        $categoryArr = Category::where('status','=',1)
            ->orderBy('sort','asc')
            ->get();
        return view('Admin.Article.showList')->with('categoryArr',$categoryArr);
    }

    //添加页
    public function add(){
        $categoryArr = Category::where('status','=',1)
            ->orderBy('sort','asc')
            ->get();
        return view('Admin.Article.add')->with('categoryArr',$categoryArr);
    }

    //执行添加
    public function ajaxAdd(Request $request){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $articleOrm = new Article();
        if ($request->file('img')){
            // $path = $request->file('img')->store('article/'.date('Y-m-d'),'myUploads');
            // $articleOrm->img = $path;
            $date = date('Y-m-d');
            $requestImg = $request->file('img');
            $saveFileName = md5(time().str_random()).'.'.$requestImg->getClientOriginalExtension();
            $savePath = public_path('uploads/article/'.$date);
            if(!is_dir($savePath)){
                //因为 \Image-->save($savePath); 用的是 file_put_contents() 方法
                //而 file_put_contents() 方法不会创建文件夹，只会创建文件
                //所以当 file_put_contents($savePath,$data) 找不到 $savePath 时会报错
                mkdir($savePath,0777,true);
            }
            $requestImgRealPath = $requestImg->getRealPath();
            $watermarkImgPath = public_path('watermarkImg/watermark.png');
            \Image::make($requestImgRealPath)->insert($watermarkImgPath,'bottom-right', 15, 10)->resize(185,null,function ($constraint) {
                $constraint->aspectRatio();
            })->save($savePath.'/'.$saveFileName);
            $articleOrm->img = 'article/'.$date.'/'.$saveFileName;
        }
        $articleOrm->addDate = date('Y-m-d');
        $articleOrm->author = session()->get('adminInfo')['name'];
        $articleOrm->showNum = 0;
        $articleOrm->category_id = $request->input('category_id');
        $articleOrm->category_name = '';
        $articleOrm->title = $request->input('title');
        $articleOrm->sort = $request->input('sort');
        $articleOrm->outline = $request->input('outline');
        $articleOrm->status = $request->input('status');
        $articleOrm->isHome = $request->input('isHome');
        $articleOrm->isRecommend = $request->input('isRecommend');
        if ($request->input('content')){
            $articleOrm->content = $request->input('content');
        }else{
            $articleOrm->content = '';
        }
        $articleOrm->save();
        $res['status'] = true;
        $res['echo'] = '添加成功';
        return $res;
    }

    //修改页
    public function edit(){
        $id = \Route::input('id');
        $articleInfo = Article::find($id);
        $categoryArr = Category::where('status','=',1)
            ->orderBy('sort','asc')
            ->get();
        return view('Admin.Article.edit')->with('categoryArr',$categoryArr)
            ->with('articleInfo',$articleInfo);
    }

    //执行修改
    public function ajaxEdit(Request $request){
        $id = $request->input('id');
        $articleOrm = Article::find($id);
        if ($request->file('img')){
            @unlink(public_path('uploads/').$articleOrm->img);
            // $path = $request->file('img')->store('article/'.date('Y-m-d'),'myUploads');
            // $articleOrm->img = $path;
            $date = date('Y-m-d');
            $requestImg = $request->file('img');
            $saveFileName = md5(time().str_random()).'.'.$requestImg->getClientOriginalExtension();
            $savePath = public_path('uploads/article/'.$date);
            if(!is_dir($savePath)){
                //因为 \Image-->save($savePath); 用的是 file_put_contents() 方法
                //而 file_put_contents() 方法不会创建文件夹，只会创建文件
                //所以当 file_put_contents($savePath,$data) 找不到 $savePath 时会报错
                mkdir($savePath,0777,true);
            }
            $requestImgRealPath = $requestImg->getRealPath();
            $watermarkImgPath = public_path('watermarkImg/watermark.png');
            \Image::make($requestImgRealPath)->insert($watermarkImgPath,'bottom-right', 15, 10)->resize(185,null,function ($constraint) {
                $constraint->aspectRatio();
            })->save($savePath.'/'.$saveFileName);
            $articleOrm->img = 'article/'.$date.'/'.$saveFileName;
        }
        if ($request->input('category_id')){
            $articleOrm->category_id = $request->input('category_id');
            $articleOrm->category_name = '';
        }
        if ($request->input('title')){
            $articleOrm->title = $request->input('title');
        }
        if ($request->input('sort')){
            $articleOrm->sort = $request->input('sort');
        }
        if ($request->input('outline')){
            $articleOrm->outline = $request->input('outline');
        }
        if ($request->input('status') !== null){
            $articleOrm->status = $request->input('status');
        }
        if ($request->input('isHome') !== null){
            $articleOrm->isHome = $request->input('isHome');
        }
        if ($request->input('isRecommend') !== null){
            $articleOrm->isRecommend = $request->input('isRecommend');
        }
        if ($request->input('content')){
            $articleOrm->content = $request->input('content');
        }
        if ($request->input('showNum')){
            $articleOrm->showNum = $request->input('showNum');
        }
        $articleOrm->save();
        $res['status'] = true;
        $res['echo'] = '修改成功';
        return $res;
    }

    //删除
    public function ajaxDel(){
        $res = array(
            'status' => false,
            'echo'  => ''
        );
        $ids = $_GET['id'];
        $ids = trim($ids,',');
        $articleOrm = Article::whereIn('id',explode(',',$ids))->get();
        foreach ($articleOrm as $item) {
            @unlink(public_path('uploads/').$item->img);
        }
        Article::destroy(explode(',',$ids));
        $res['status'] = true;
        $res['echo'] = '删除成功';
        return $res;
    }

    //评论列表
    public function commentList(Request $request){
        $article_id = intval(\Route::input('article_id'));
        if (\Route::input('action')){
            //返回数据格式
            $return =array('code'=>0,'msg'=>'','count'=>0,'data'=>array());
            $whereArray = array();
            $whereArray[] = ['article_id','=',$article_id];
            $orWhereArray = array();
            if ($request->input('startTime')){
                $whereArray[] = ['time','>=',strtotime($request->input('startTime'))];
            }
            if ($request->input('endTime')){
                $whereArray[] = ['time','<=',strtotime($request->input('endTime'))+86400];
            }
            if ($request->input('keyWord')){
                $orWhereArray[] = ['article_name','like','%'.$request->input('keyWord').'%'];
                $orWhereArray[] = ['user_account','like','%'.$request->input('keyWord').'%'];
            }
            $data = ArticleComment::where($whereArray)
                ->where(function ($query) use ($orWhereArray){
                    foreach ($orWhereArray as $item) {
                        $query->orWhere($item[0],$item[1],$item[2]);
                    }
                })
                ->orderBy('time','desc')
                ->paginate($request->input('limit'))
                ->toArray();
            $return['count'] = $data['total'];
            $return['data'] = $data['data'];
            return $return;
        }
        return view('Admin.Article.commentList')->with('article_id',$article_id);
    }
}
