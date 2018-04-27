{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '管理员修改')
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
		<input type="hidden" name="id" value="{{ session()->get('adminInfo')['id'] }}" />
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label">角色</label>
				<div class="layui-input-inline">
					@if(session()->get('adminInfo')['role_id']==0)
						<input type="text" class="layui-input" value="超级管理员" readonly style="border:none;">
					@else
						<input type="text" class="layui-input" value="{{$roleInfo->name}}" readonly style="border:none;">
					@endif
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">登录账号</label>
				<div class="layui-input-inline">
					<input type="text" name="account" lay-verify="required|account" autocomplete="off" class="layui-input" value="{{ session()->get('adminInfo')['account'] }}">
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label">登录密码</label>
				<div class="layui-input-inline">
					<input type="password" name="password" lay-verify="password" autocomplete="off" class="layui-input" placeholder="不填为不修改">
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">确认密码</label>
				<div class="layui-input-inline">
					<input type="password" name="password2" lay-verify="password2" autocomplete="off" class="layui-input">
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label">姓名</label>
				<div class="layui-input-inline">
					<input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input" value="{{ session()->get('adminInfo')['name'] }}">
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">性别</label>
				<div class="layui-input-inline">
					<input type="radio" name="sex" value="男" title="男" @php echo session()->get('adminInfo')['sex']=='男'?'checked':''@endphp>
					<input type="radio" name="sex" value="女" title="女" @php echo session()->get('adminInfo')['sex']=='女'?'checked':''@endphp>
				</div>
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-inline">
				<label class="layui-form-label">手机</label>
				<div class="layui-input-inline">
					<input type="text" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input" value="{{ session()->get('adminInfo')['phone'] }}">
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">邮箱</label>
				<div class="layui-input-inline">
					<input type="text" name="email" lay-verify="required|email" autocomplete="off" class="layui-input" value="{{ session()->get('adminInfo')['email'] }}">
				</div>
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
        form.verify({
            account: function(value, item){ //value：表单的值、item：表单的DOM对象
                if (value.length<=2) {
                    return '用户名至少3个字符'
                };
                if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\s·]+$").test(value)){
                    return '用户名不能有特殊字符';
                }
                if(/(^\_)|(\__)|(\_+$)/.test(value)){
                    return '用户名首尾不能出现下划线\'_\'';
                }
                if(/^\d+\d+\d$/.test(value)){
                    return '用户名不能全为数字';
                }
            },
            password: function(value,item){
                if(value.length>0){
                    if(/^[\S]{6,16}$/.test(value)){
                    }else{
                        return '密码必须6到16位，且不能出现空格';
                    }
                }
            }
        });
        form.on('submit(submit)', function(data){
            //不知为何不会自动触发，所以改成手动验证
            var passwordValue = $('input[name=password]').val();
            var passwordValue2 = $('input[name=password2]').val();
            if (passwordValue !== passwordValue2) {
                $('input[name=password2]').focus();
                $('input[name=password2]').attr('class','layui-input layui-form-danger');
                layer.msg('两次输入的密码不一致!', {icon: 5,anim: 6});
                return false;
            }else{
                $('input[name=password2]').attr('class','layui-input');
            }
            $.ajax({
                url:"{{ url('myadmin/Index/ajaxEdit') }}",
                type:'post',
                data:data.field,
                dataType:'json',
                success:function(result){
                    if (result.name != '') {
                        parent.$('#adminInfoName').text(result.name);
                        parent.$('#adminInfoName').append('<span class="layui-nav-more"></span>');
                    };
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