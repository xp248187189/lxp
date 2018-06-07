{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '权限添加')
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
    <form class="layui-form" action="">
        <input type="hidden" name="pid" value="{{$pid}}" />
        <input type="hidden" name="level" value="{{$level}}" />
        <input type="hidden" name="id_list" value="{{$id_list}}" />
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">控制器</label>
            <div class="layui-input-block">
                <input type="text" name="controller" @php echo $pid==0?'disabled placeholder="无需填写"':'lay-verify="required"'@endphp autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">方法</label>
            <div class="layui-input-block">
                <input type="text" name="action" @php echo $pid==0?'disabled placeholder="无需填写"':'lay-verify="required"'@endphp autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sort" lay-verify="number" autocomplete="off" class="layui-input" value="99">
            </div>
        </div>
        @if($level<2)
        <div class="layui-form-item">
            <label class="layui-form-label">图标</label>
            <div class="layui-input-block" style="height:150px;overflow:auto;">
                @foreach($iconClass as $key => $value)
                        <input type="radio" name="icon" value="{{$value}}" title="<i class='fa fa-fw {{$value}}'></i>">
                @endforeach
            </div>
        </div>
        @endif
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
                url:"{{url('/Auth/ajaxAdd')}}",
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