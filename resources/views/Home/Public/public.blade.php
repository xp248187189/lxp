<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="keywords" content="{{cache('about_cache')[2]->label}}">
    <meta name="description" content="{{cache('about_cache')[3]->label}}">
    <link rel="icon" href="{{asset('favicon.ico')}}" />
    {{--百度搜索资源平台(验证)--}}
    <meta name="baidu-site-verification" content="hQ7PceVrnU" />
    {{--Google Search Console(验证)--}}
    <meta name="google-site-verification" content="blCIvm274GhkrcVqo36Y8LEdbTFA5OorGpJFFDmBnZg" />
    {{--必应搜索(验证)--}}
    <meta name="msvalidate.01" content="11D6690AA495733E9C9557098289F370" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/font-awesome/css/font-awesome.css') }}">
    {{--全局样式--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/global.css') }}">
    {{--看板娘--}}
    <link rel="stylesheet" href="{{ asset('live2d/css/live2d.css') }}" />
    @section('loadCss')

    @show
    @section('style')

    @show
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        {{--百度统计代码--}}
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?9c139be32c405b096ada0ec78addca3b";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body>
@php
    //获取当前路由 格式:App\Http\Controllers\Admin\IndexController@index
   $action = request()->route()->getAction();
   $controllerName = $action['controller'];
   $controllerNameArr = explode('\\',$controllerName);
    //获取控制器及方法 格式:IndexController@index
    $end = end($controllerNameArr);
    $endArr = explode('@',$end);
    $endArr[0] = substr($endArr[0],0,-10);
    $controllerName = $endArr[0];
@endphp
<nav class="blog-nav layui-header">
    <div class="blog-container">
        {{--QQ互联登陆--}}
        @if(empty($_COOKIE['user_openid']))
        <a href="javascript:;" class="blog-user" onclick="location.href='{{url('qqLogin')}}'">
            <i class="fa fa-qq"></i>
        </a>
        @else
        <a href="javascript:;" class="blog-user" onclick="location.href='{{url('userLogOut')}}'">
            <img src="{{request()->cookie('user_head')}}"/>
        </a>
        @endif
        {{--记忆碎片--}}
        <a class="blog-logo" href="{{url('/')}}">{{cache('about_cache')[1]->name}}</a>
        {{--导航菜单--}}
        <ul class="layui-nav" lay-filter="nav">
            <li class="layui-nav-item @php echo $controllerName=='Index'?'layui-this':'' @endphp">
                <a href="{{url('/')}}"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='Article'?'layui-this':'' @endphp">
                <a href="{{url('/Article')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='Archive'?'layui-this':'' @endphp">
                <a href="{{url('/Archive')}}"><i class="fa fa-folder-open fa-fw"></i>&nbsp;文章归档</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='TimeAxis'?'layui-this':'' @endphp">
                <a href="{{url('/TimeAxis')}}"><i class="fa fa-hourglass-half fa-fw"></i>&nbsp;心情驿站</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='Joke'?'layui-this':'' @endphp">
                <a href="{{url('/Joke')}}"><i class="fa fa-pagelines fa-fw"></i>&nbsp;轻松一刻</a>
                @if($controllerName != 'Joke')
                    <dl class="layui-nav-child" style="background-color: #393D49;">
                        <dd><a href="{{url('/Joke#tabIndex=1')}}" style="color: #5FB878;">开心一笑</a></dd>
                        <dd><a href="{{url('/Joke#tabIndex=2')}}" style="color: #5FB878;">历史上的今天</a></dd>
                    </dl>
                @endif
            </li>
            <li class="layui-nav-item @php echo $controllerName=='About'?'layui-this':'' @endphp">
                <a href="{{url('/About')}}"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
                @if($controllerName != 'About')
                <dl class="layui-nav-child" style="background-color: #393D49;">
                    <dd><a href="{{url('/About#tabIndex=1')}}" style="color: #5FB878;">关于博客</a></dd>
                    <dd><a href="{{url('/About#tabIndex=2')}}" style="color: #5FB878;">关于作者</a></dd>
                    <dd><a href="{{url('/About#tabIndex=3')}}" style="color: #5FB878;">网站推荐</a></dd>
                    <dd><a href="{{url('/About#tabIndex=4')}}" style="color: #5FB878;">留言墙</a></dd>
                </dl>
                @endif
            </li>
        </ul>
        {{--手机和平板的导航开关--}}
        <a class="blog-navicon" href="javascript:;">
            <i class="fa fa-navicon"></i>
        </a>
    </div>
</nav>
@section('body')

@show
<footer class="blog-footer">
    <p><span>Copyright</span><span>&copy;</span><span>2017@php echo date("Y")==2017?'':'-'.date("Y");@endphp</span><a href="{{url('/')}}">记忆碎片</a><span>All Rights Reserved</span></p>
    <p><a href="http://www.miitbeian.gov.cn/" target="_blank">蜀ICP备17041911号</a></p>
</footer>
{{--侧边导航--}}
<ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
    <li class="layui-nav-item @php echo $controllerName=='Index'?'layui-this':'' @endphp">
        <a href="{{url('/')}}"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='Article'?'layui-this':'' @endphp">
        <a href="{{url('/Article')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='Archive'?'layui-this':'' @endphp">
        <a href="{{url('/Archive')}}"><i class="fa fa-folder-open fa-fw"></i>&nbsp;文章归档</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='TimeAxis'?'layui-this':'' @endphp">
        <a href="{{url('/TimeAxis')}}"><i class="fa fa-road fa-fw"></i>&nbsp;心情驿站</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='Joke'?'layui-this':'' @endphp">
        <a href="javascript:void(0)"><i class="fa fa-pagelines fa-fw"></i>&nbsp;轻松一刻</a>
        @if($controllerName != 'Joke')
            <dl class="layui-nav-child">
                <dd><a href="{{url('/Joke#tabIndex=1')}}">开心一笑</a></dd>
                <dd><a href="{{url('/Joke#tabIndex=2')}}">历史上的今天</a></dd>
            </dl>
        @endif
    </li>
    <li class="layui-nav-item @php echo $controllerName=='About'?'layui-this':'' @endphp">
        <a href="javascript:void(0)"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
        @if($controllerName != 'About')
            <dl class="layui-nav-child">
                <dd><a href="{{url('/About#tabIndex=1')}}">关于博客</a></dd>
                <dd><a href="{{url('/About#tabIndex=2')}}">关于作者</a></dd>
                {{--<dd><a href="{{url('/About#tabIndex=3')}}">网站推荐</a></dd>--}}
                <dd><a href="{{url('/About#tabIndex=4')}}">留言墙</a></dd>
            </dl>
        @endif
    </li>
</ul>
{{--分享窗体--}}
<div class="blog-share layui-hide">
    <div class="blog-share-body">
        <div style="width: 200px;height:100%;">
            <div class="bdsharebuttonbox">
                <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                <a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
            </div>
        </div>
    </div>
</div>
{{--遮罩--}}
<div class="blog-mask animated layui-hide"></div>
{{--看板娘--}}
<div id="landlord">
    <div class="message" style="opacity:0"></div>
    <canvas id="live2d" width="280" height="250" class="live2d"></canvas>
    <div class="hide-button">隐藏</div>
</div>
<script>
    {{--百度搜索资源平台(自动推送工具)--}}
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
</script>
<script src="{{ asset('Common/layui/layui.all.js') }}"></script>
<script src="{{ asset('Common/layui/layuiGlobal.js') }}"></script>
<script src="{{ asset('Common/js/functions.js') }}"></script>
<script src="{{ asset('Home/js/global.js') }}"></script>
@section('loadScript')

@show
<script type="text/javascript">
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    {{--百度分享插件--}}
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdStyle": "0",
            "bdSize": "32"
        },
        "share": {}
    };
    with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src='{{asset("static/api/js/share.js")}}?cdnversion='+~(-new Date()/36e5)];
</script>
<script type="text/javascript">
    var message_Path = '/live2d/'
    var home_Path = '{{\Illuminate\Support\Facades\Request::server("HTTP_HOST").'/'}}'  //此处修改为你的域名，必须带斜杠
</script>
<script type="text/javascript" src="{{asset('live2d/js/live2d.js')}}"></script>
<script type="text/javascript" src="{{asset('live2d/js/message.js')}}"></script>
<script type="text/javascript">
    loadlive2d("live2d", "/live2d/model/tia/model.json");
</script>
@section('script')

@show
</body>
</html>