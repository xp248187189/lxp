{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '网站公告添加')
{{--body内容--}}
@section('body')
    <form class="layui-form" action="" id="myform">
        <div class="layui-form-item">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea id="content" name="content"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" lay-verify="required" autocomplete="off" class="layui-input" value="99">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="启用" checked>
                <input type="radio" name="status" value="0" title="禁止">
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
        //编辑器
        var editIndex = layedit.build('content',{
            height: 120, //设置编辑器高度
            tool: [
                'strong', //加粗
                'italic', //斜体
                'underline', //下划线
                'del', //删除线
                '|', //分割线
                'left', //左对齐
                'center', //居中对齐
                'right', //右对齐
                'link', //超链接
                'unlink', //清除链接
                'face' //表情
            ]
        });
        form.on('submit(submit)', function(data){
            layedit.sync(editIndex);
            $.ajax({
                url:"{{url('myadmin/Notice/ajaxAdd')}}",
                type:'post',
                data:getFormData('myform'),
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