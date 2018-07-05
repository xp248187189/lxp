{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '网站推荐修改')
{{--body内容--}}
@section('body')
    <form class="layui-form" action="">
        <input type="hidden" name="id" value="{{$LinkInfo->id}}">
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required|name" autocomplete="off" class="layui-input" value="{{$LinkInfo->name}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">URL</label>
            <div class="layui-input-block">
                <input type="text" name="url" lay-verify="required" autocomplete="off" class="layui-input" value="{{$LinkInfo->url}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">图标URL</label>
            <div class="layui-input-block">
                <input type="text" name="icoUrl" autocomplete="off" class="layui-input" value="{{$LinkInfo->icoUrl}}" placeholder="默认为：URL/favicon.ico">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" lay-verify="required" autocomplete="off" class="layui-input" value="{{$LinkInfo->sort}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">首页显示</label>
            <div class="layui-input-block">
                <input type="radio" name="isHome" value="1" title="是" <?php echo $LinkInfo->isHome=='1'?'checked':'';?>>
                <input type="radio" name="isHome" value="0" title="否" <?php echo $LinkInfo->isHome=='0'?'checked':'';?>>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="启用" <?php echo $LinkInfo->status=='1'?'checked':'';?>>
                <input type="radio" name="status" value="0" title="禁止" <?php echo $LinkInfo->status=='0'?'checked':'';?>>
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
                url:"{{url('/Link/ajaxEdit')}}",
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