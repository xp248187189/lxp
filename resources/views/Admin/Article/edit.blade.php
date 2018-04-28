{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '文章修改')
{{--style样式--}}
@section('style')
    <style type="text/css">
        .layui-form-item{
            margin-bottom: 0;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    <form class="layui-form" action="" id="editForm" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{{$articleInfo->id}}" />
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">分类</label>
                <div class="layui-input-inline">
                    <select name="category_id">
                        @foreach($categoryArr as $key=>$value)
                            <option value="{{$value->id}}" @php echo $articleInfo->category_id==$value->id?'selected':''@endphp>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-inline">
                    <input type="text" name="title" lay-verify="required" autocomplete="off" class="layui-input" value="{{$articleInfo->title}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="text" name="sort" lay-verify="number" autocomplete="off" class="layui-input" value="{{$articleInfo->sort}}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">概要</label>
            <div class="layui-input-block">
                <input type="text" name="outline" lay-verify="required" autocomplete="off" class="layui-input" value="{{$articleInfo->outline}}">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline">
                    <input type="radio" name="status" value="1" class="layui-input" title="启用" @php echo $articleInfo['status']==1?'checked':''@endphp>
                    <input type="radio" name="status" value="0" class="layui-input" title="禁止" @php echo $articleInfo['status']==0?'checked':''@endphp>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">首页显示</label>
                <div class="layui-input-inline">
                    <input type="radio" name="isHome" value="1" class="layui-input" title="是" @php echo $articleInfo['isHome']==1?'checked':''@endphp>
                    <input type="radio" name="isHome" value="0" class="layui-input" title="否" @php echo $articleInfo['isHome']==0?'checked':''@endphp>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">推荐显示</label>
                <div class="layui-input-inline">
                    <input type="radio" name="isRecommend" value="1" class="layui-input" title="是" @php echo $articleInfo['isRecommend']==1?'checked':''@endphp>
                    <input type="radio" name="isRecommend" value="0" class="layui-input" title="否" @php echo $articleInfo['isRecommend']==0?'checked':''@endphp>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">主图</label>
            <div class="layui-input-inline">
                <button type="button" onclick="selImg();" class="layui-btn layui-btn-sm" style="margin-top: 4px;">
                    <i class="fa fa-image"></i>
                    浏览文件
                </button>
                <input type="file" name="img" id="img" style="display:none;">
                <input type="hidden" id="checkCardPath" value="1" />
            </div>
            <div class="layui-form-mid layui-word-aux" id="showPath">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <img style="width:150px;" id="show_img" src="@php echo asset('uploads').'/'.$articleInfo->img@endphp">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                {{showUEditor('content',$articleInfo->content)}}
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        //图片展示
        $("#img").change(function(){
            var filepath=$("#img").val();
            if(filepath.length>0){
                var extStart = filepath.lastIndexOf(".");
                var ext = filepath.substring(extStart, filepath.length).toUpperCase();
                if (ext != ".BMP" && ext != ".PNG" && ext != ".GIF" && ext != ".JPG" && ext != ".JPEG") {
                    $('#checkCardPath').val(2);//1没问题 2格式问题,3未选择
                    $('#showPath').html('<span style="color:red;">图片限于bmp,png,gif,jpeg,jpg格式</span>');
                    $("#show_img").attr("src", "") ;
                    return false;
                }
                $('#showPath').html(filepath);
                $('#checkCardPath').val(1);
                var objUrl = getObjectURL(this.files[0]) ;
                if (objUrl) {
                    $("#show_img").attr("src", objUrl) ;
                }
            }else{
                $('#checkCardPath').val(3);
                $("#show_img").attr("src", "") ;
                $('#showPath').html('<span style="color:red;">请选择图片</span>');
            }
        });
        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file) ;
            }
            return url ;
        }
        //点击按钮选择图片
        function selImg(){
            $('input[name="img"]').click();
        }
        form.on('submit(submit)', function(data){
            if ($('#checkCardPath').val()==2) {
                layer.msg('图片限于bmp,png,gif,jpeg,jpg格式');
                return false;
            }else if($('#checkCardPath').val()==3){
                layer.msg('请选择主图');
                return false;
            }
            var formParam = new FormData($("#editForm")[0]);;
            $.ajax({
                url:"{{url('myadmin/Article/ajaxEdit')}}",
                type:'post',
                data:formParam,
                cache:false,
                contentType: false, //必须
                processData: false, //必须   
                dataType:'json',
                success:function(result){
                    layer.msg(result.echo);
                },
                error:function(result){
                    layer.msg('程序错误!');
                }
            });
            return false;
        });
    </script>
@endsection