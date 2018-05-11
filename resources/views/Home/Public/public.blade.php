<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/font-awesome/css/font-awesome.css') }}">
    {{--全局样式--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/global.css') }}">
    @section('loadCss')

    @show
    @section('style')

    @show
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
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
        <a class="blog-logo" href="{{url('/')}}">{{$blogInfo->name}}</a>
        {{--导航菜单--}}
        <ul class="layui-nav" lay-filter="nav">
            <li class="layui-nav-item @php echo $controllerName=='Index'?'layui-this':'' @endphp">
                <a href="{{url('/')}}"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='Article'?'layui-this':'' @endphp">
                <a href="{{url('/Article')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='TimeAxis'?'layui-this':'' @endphp">
                <a href="{{url('/TimeAxis')}}"><i class="fa fa-hourglass-half fa-fw"></i>&nbsp;点点滴滴</a>
            </li>
            <li class="layui-nav-item @php echo $controllerName=='About'?'layui-this':'' @endphp">
                <a href="{{url('/About')}}"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
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
    <p><a href="http://www.miitbeian.gov.cn/" target="_blank">蜀ICP备17041911号-1</a></p>
</footer>
{{--侧边导航--}}
<ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
    <li class="layui-nav-item @php echo $controllerName=='Index'?'layui-this':'' @endphp">
        <a href="{{url('/')}}"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='Article'?'layui-this':'' @endphp">
        <a href="{{url('/Article')}}"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='TimeAxis'?'layui-this':'' @endphp">
        <a href="{{url('/TimeAxis')}}"><i class="fa fa-road fa-fw"></i>&nbsp;点点滴滴</a>
    </li>
    <li class="layui-nav-item @php echo $controllerName=='About'?'layui-this':'' @endphp">
        <a href="{{url('/About')}}"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
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
<script>
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
    //百度分享插件
    window._bd_share_config = {
        "common": {
            "bdSnsKey": {},
            "bdText": "",
            "bdStyle": "0",
            "bdSize": "32"
        },
        "share": {}
    };
    with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src={{asset('')}}'/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>
@section('script')

@show
</body>
</html>