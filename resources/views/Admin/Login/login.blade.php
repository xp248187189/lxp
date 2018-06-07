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
            background: #000;
            overflow:hidden;
        }
        canvas{
            margin: 0 auto;
            display: block;
            background-color: #FFF;
            position: fixed;
            z-index:-1;
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
    <canvas id="canvas">
        您的浏览器不支持canvas
    </canvas>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        //自定义验证
        form.verify({
            account: function(value, item){ //value：表单的值、item：表单的DOM对象
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
        //监听登陆提交
        form.on('submit(login)', function (data) {
            var index = layer.load(1);
            $.ajax({
                url:'{{ url('/doLogin') }}',// 跳转到 action
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
                        getVerify();
                        $('input[name=verify]').val('');
                    }
                },
                error : function() {
                    layer.close(index);
                    layer.msg('程序异常,请稍后重试!');
                }
            });
            return false;
        });
        //检测键盘按下
        $('body').keyup(function (e) {
            if (e.keyCode == 13) {  //Enter键
                if ($('#layer-login').length <= 0) {
                    //登录框不存在，则显示登录框
                    loginHtml();
                } else {
                    //登录框存在不做任何操作
                    //因为layui表单自动绑定了Enter键提交表单，所以不用再模拟点击一次
                    // $('button[lay-filter=login]').click();
                }
            }
        });
        //点击div出现登录框
        $('.enter').click(function(){
            loginHtml();
        });
        //登录框
        function loginHtml(){
            var loginHtml = '';
            loginHtml += '<form class="layui-form" action="">';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<label class="layui-form-label">账号</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="text" name="account" lay-verify="account|required" placeholder="请输入账号" value="" autocomplete="off" class="layui-input">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<label class="layui-form-label">密码</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="password" name="password" lay-verify="password|required" placeholder="请输入密码" value="" autocomplete="off" class="layui-input">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<div class="layui-inline">'
            loginHtml += '<label class="layui-form-label">验证码</label>';
            loginHtml += '<div class="layui-input-inline" style="width:156px;">';
            loginHtml += '<input type="text" name="verify" lay-verify="required" placeholder="请输入验证码" value="" autocomplete="off" class="layui-input">';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-input-inline" style="width:114px;">';
            loginHtml += '<img id="verify_img" src="/captcha/default?'+Math.random()+'" onclick="getVerify();" style="height:38px;">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item">';
            loginHtml += '<label class="layui-form-label">7天免登录</label>';
            loginHtml += '<div class="layui-input-inline pm-login-input">';
            loginHtml += '<input type="checkbox" name="online" title="确定" value="1">';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '<div class="layui-form-item" style="margin-top:25px;margin-bottom:0;">';
            loginHtml += '<div class="layui-input-block">';
            loginHtml += '<button class="layui-btn" style="width:230px;" lay-submit lay-filter="login">立即登录</button>';
            loginHtml += '</div>';
            loginHtml += '</div>';
            loginHtml += '</form>';
            layer.open({
                id: 'layer-login',
                type: 1,
                title: false,
                shade: 0.4,
                shadeClose: true,
                area: ['480px', '330px'],
                closeBtn: 0,
                // anim: 1,
                skin: 'pm-layer-login',
                content: loginHtml,
                success: function(layero, index){
                    form.render();
                }
            });
        }
        /**
         * 获取验证码
         */
        function getVerify(){
            $('#verify_img').attr('src',"/captcha/default?"+Math.random());
        }
        /**
         * canvas动画
         */
        var canvas = document.getElementById(`canvas`), //获取画布
            cxt = canvas.getContext(`2d`), //获得2d绘图环境
            size = 12;//设置字体大小和列宽
        //注意点：canvas不能在样式里设置宽高，那是对默认300*150的一个拉伸变形。
        //可以直接在标签上设置宽高，如：width="500" height="500"(像图片标签那样)。
        canvas.width = window.screen.width; //设置画布宽度
        canvas.height = window.screen.height;//设置画布高度
        var y = [], //用数组存储每一列更新后的y坐标
            cols = canvas.width/size; //根据每一列宽为size来计算列数
        //初始化每一列y值(随机)，取不同的值让雨点错开（不并排下落）
        for(var i=0;i<cols;i++){
            y[i] = Math.random()*800;
        }
        //画图函数
        (function draw(){
            //理解难点就是以下这个背景覆盖
            cxt.fillStyle = `rgba(0,0,0,.1)`; //设置背景颜色和透明度（将会叠加，形成渐变）
            cxt.fillRect(0,0,canvas.width,canvas.height); //描绘每一行背景
            cxt.fillStyle = `#33ff00`; //设置字体颜色
            cxt.font = `${size}px Microsoft yahei`; //设置字体
            for(var i=0;i<cols;i++){//描绘所有列
                var num = Math.floor(Math.random()*10)+'';//获取0-9随机数
                var numX = i*size;//第i列的x坐标
                var numY = y[i];//第i列的y坐标
                cxt.fillText(num,numX,numY);//描绘数字
                y[i] += size;//增加size高度以写该列中下一个（行）数字的y坐标
                if(y[i]>=canvas.height && Math.random()>=.9){ //随机取值进一步控制雨点错开
                    y[i] = 0; //回到顶部再写
                }
            }
            window.requestAnimationFrame(draw);//帧动画函数
        })();
    </script>
@endsection
