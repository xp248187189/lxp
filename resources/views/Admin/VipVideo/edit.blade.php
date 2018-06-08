{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '网站推荐修改')
{{--body内容--}}
@section('body')
    <form class="layui-form" action="">
        <input type="hidden" name="id" value="{{$VipVideoInfo->id}}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input" value="{{$VipVideoInfo->name}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">URL</label>
            <div class="layui-input-block">
                <input type="text" name="url" lay-verify="required" autocomplete="off" class="layui-input" value="{{$VipVideoInfo->url}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-block">
                <input type="radio" name="type" value="1" title="API" <?php echo $VipVideoInfo->type=='1'?'checked':'';?>>
                <input type="radio" name="type" value="2" title="播放地址" <?php echo $VipVideoInfo->type=='2'?'checked':'';?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="启用" <?php echo $VipVideoInfo->status=='1'?'checked':'';?>>
                <input type="radio" name="status" value="0" title="禁止" <?php echo $VipVideoInfo->status=='0'?'checked':'';?>>
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
                url:"{{url('/VipVideo/ajaxEdit')}}",
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