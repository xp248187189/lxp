{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '关键字与描述')
{{--body内容--}}
@section('body')
    <form class="layui-form" action="" id="editForm">
        <div class="layui-form-item">
            <label class="layui-form-label">关键字</label>
            <div class="layui-input-block">
                <input type="text" name="label_1" lay-verify="required" autocomplete="off" class="layui-input" value="{{$keywords_info->label}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <input type="text" name="label_2" lay-verify="required" autocomplete="off" class="layui-input" value="{{$description_info->label}}">
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
        form.on('submit(submit)', function(data){
            var formParam = new FormData($("#editForm")[0]);;
            $.ajax({
                url:"{{url('/Seo/ajaxEdit')}}",
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