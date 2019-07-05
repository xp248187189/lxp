{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '管理员登录')
{{--加载登录页面的css--}}
@section('loadCss')
    <link href="{{ asset('Admin/css/login.css') }}" rel="stylesheet" />
@endsection
{{--style样式--}}
@section('style')
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        body{
            background: #CCCCCC;
            overflow:hidden;
            background: url({{randGetBingEverydayImgForOnline()}}) no-repeat;
            background-size:cover;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    <div class="mask"></div>
    <div class="main">
        <h1>
            <span style="font-size:84px;cursor:pointer;">B</span><span style="font-size:30px;cursor:pointer;">log</span>
        </h1>
        <p id="time"></p>
        <div class="enter">
            Please&nbsp;&nbsp;Click&nbsp;&nbsp;Enter
        </div>
    </div>
    {{--<canvas id="canvas">--}}
        {{--您的浏览器不支持canvas--}}
    {{--</canvas>--}}
@endsection
{{--js内容--}}
@section('script')
    <script src="https://cdn.vaptcha.com/v2.js"></script>
    <script type="text/javascript">
        {{--自定义验证--}}
        form.verify({
            account: function(value, item){ {{--value：表单的值、item：表单的DOM对象--}}
                if(value.length<=2){
                    return '用户名不应该少于3位字符';
                }
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
            password: [
                /^[\S]{6,16}$/,
                '密码必须6到16位，且不能出现空格'
            ]
        });
        {{--监听登陆提交--}}
        form.on('submit(login)', function (data) {
            var form_data = data.field;
            if (form_data.token == ''){
                layer.msg('请进行人机验证');
                return false;
            }
            var index = layer.load(1);
            $.ajax({
                url:'{{ url('/doLogin') }}',
                type:'post',
                data:data.field,
                cache:false,
                dataType:'json',
                success:function(data) {
                    if(data.status){
                        layer.msg('登陆成功，正在跳转......',{icon:6,time: 2000},function(){
                            window.location.href="{{ url('/') }}";
                        });
                    }else{
                        layer.close(index);
                        layer.msg(data.echo,{icon:5});
                        $('.vp-refresh').click();
                        $('input[name="token"]').val('');
                    }
                },
                error : function(data) {
                    var retry_after = data.getResponseHeader('retry-after');
                    layer.close(index);
                    if (data.responseJSON.echo){
                        layer.msg('对不起！系统检测到您疑是恶意登录，请'+retry_after+'秒后再试！');
                    }else{
                        layer.msg('程序错误!');
                    }
                }
            });
            return false;
        });
        {{--检测键盘按下--}}
        $('body').keyup(function (e) {
            if (e.keyCode == 13) {  {{--Enter键--}}
                if ($('#layer-login').length <= 0) {
                    {{--登录框不存在，则显示登录框--}}
                    loginHtml();
                } else {
                    {{--判断三个输入框是否获取焦点，都没有获取焦点就模拟点击--}}
                    {{--如果获取了焦点，因为layui表单自动绑定了Enter键提交表单，所以不用再模拟点击一次--}}
                    var accountInputIsFocus =  $('input[name="account"]').is(':focus');
                    var passwordInputIsFocus =  $('input[name="password"]').is(':focus');
                    if (accountInputIsFocus==false && passwordInputIsFocus==false){
                        var token = $('input[name="token"]').val();
                        if (token == ''){
                            layer.msg('请进行人机验证');
                            return false;
                        }
                        $('button[lay-filter=login]').click();
                    }
                }
            }
        });
        {{--点击div出现登录框--}}
        $('.enter').click(function(){
            loginHtml();
        });
        {{--登录框--}}
        function loginHtml(){
            var loginHtml = '';
            loginHtml += '<form class="layui-form" action="">';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<label class="layui-form-label">账号</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="text" name="account" lay-verify="required|account" placeholder="请输入账号" value="" autocomplete="off" autofocus="autofocus" class="layui-input">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<label class="layui-form-label">密码</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="password" name="password" lay-verify="required|password" placeholder="请输入密码" value="" autocomplete="off" class="layui-input">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<input type="hidden" name="token" value="" >';
            loginHtml += '<div id="vaptchaContainer" style="width: 300px;height: 150px;margin: auto;">';
            loginHtml += '<div class="vaptcha-init-main">';
            loginHtml += '<div class="vaptcha-init-loading">';
            loginHtml += '<a href="https://www.vaptcha.com" target="_blank">';
            loginHtml += '<img src="https://cdn.vaptcha.com/vaptcha-loading.gif" />';
            loginHtml += '</a>';
            loginHtml += '<span class="vaptcha-text">验证系统启动中...</span>';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item" style="margin-top: 10px;">';
            loginHtml += '<label class="layui-form-label">7天免登录</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="checkbox" name="online" title="确定" value="1">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item" style="margin-top:25px;margin-bottom:0;">';
            loginHtml += '<div class="layui-input-block">';
            loginHtml += '<button class="layui-btn layui-btn-disabled" style="width:230px;" lay-submit lay-filter="login" id="login_btn" disabled>立即登录</button>';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '</form>';
            layer.open({
                id: 'layer-login',
                type: 1,
                title: false,
                shade: 0.4,
                shadeClose: true,
                area: ['520px', '420px'],
                closeBtn: 0,
                // anim: 1,
                skin: 'pm-layer-login',
                content: loginHtml,
                success: function(layero, index){
                    form.render();
                    vaptcha({
                        {{--配置参数--}}
                        vid: '{{ config('api.vaptcha_vid') }}', {{--验证单元id--}}
                        type: 'embed', {{--展现类型 嵌入式--}}
                        container: '#vaptchaContainer' {{--按钮容器，可为Element 或者 selector--}}
                    }).then(function (vaptchaObj) {
                        vaptchaObj.listen('pass', function() {
                            $('input[name="token"]').val(vaptchaObj.getToken());
                            $('#login_btn').removeClass("layui-btn-disabled");
                            $('#login_btn').removeAttr("disabled");
                        });
                        vaptchaObj.render() {{--调用验证实例 vaptchaObj 的 render 方法加载验证按钮--}}
                    });
                }
            });
        }
    </script>
@endsection
