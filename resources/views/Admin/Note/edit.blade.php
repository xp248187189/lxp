{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '网站记录修改')
{{--body内容--}}
@section('body')
    <form class="layui-form" action="">
        <input type="hidden" name="id" value="{{$NoteInfo->id}}">
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" autocomplete="off" class="layui-input" value="{{$NoteInfo->title}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">URL地址</label>
            <div class="layui-input-block">
                <input type="text" name="url" autocomplete="off" class="layui-input" value="{{$NoteInfo->url}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
                <input type="text" name="account" autocomplete="off" class="layui-input" value="{{$NoteInfo->account}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="text" name="password" autocomplete="off" class="layui-input" value="{{$NoteInfo->password}}">
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
            $.ajax({
                url:"{{url('/Note/ajaxEdit')}}",
                type:'post',
                data:data.field,
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