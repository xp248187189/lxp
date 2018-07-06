{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', cache('about_cache')[1]->name.' - 轻松一刻')
{{--设置样式--}}
@section('style')
    <style>
        .timeline-box {
            background: #fff;
            padding: 8px;
            position: relative;
            min-height: 90vh;
        }
        .layui-tab-brief {
            background: #fff;
            min-height: 100vh;
        }
        .layui-tab-brief .layui-tab-title {
            text-align: center;
            border-bottom: 1px solid #5FB878;
        }
        .layui-tab-brief .layui-tab-title li {
            font-size: 12px;
        }
        .layui-tab-brief .layui-tab-content {
            padding: 0;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    <script type="text/javascript">(function(){document.write(unescape('%3Cdiv id="bdcs"%3E%3C/div%3E'));var bdcs = document.createElement('script');bdcs.type = 'text/javascript';bdcs.async = true;bdcs.src = 'http://znsv.baidu.com/customer_search/api/js?sid=2739665532248753940' + '&plate_url=' + encodeURIComponent(window.location.href) + '&t=' + Math.ceil(new Date()/3600000);var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(bdcs, s);})();</script>
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a><cite>轻松一刻</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="layui-tab layui-tab-brief shadow" lay-filter="tabAbout">
                    <ul class="layui-tab-title">
                        <li class="layui-this" lay-id="1">开心一笑</li>
                        <li lay-id="2">历史上的今天</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <div class="timeline-box shadow">
                                <ul class="layui-timeline">
                                    @foreach($jokeList as $key => $value)
                                        <li class="layui-timeline-item">
                                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                            <div class="layui-timeline-content layui-text">
                                                <p>{!! str_replace(PHP_EOL,'<br/>',$value->content) !!}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="layui-timeline-item">
                                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                        <div class="layui-timeline-content layui-text">
                                            <h3 class="layui-timeline-title">END</h3>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="layui-tab-item">
                            <div class="timeline-box shadow">
                                <ul class="layui-timeline">
                                    @foreach($todayonhistory->result as $key => $value)
                                        <li class="layui-timeline-item">
                                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                            <div class="layui-timeline-content layui-text">
                                                <h3 class="layui-timeline-title">{{$value->year}}年{{$todayonhistory->today}}</h3>
                                                <p>{{$value->title}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="layui-timeline-item">
                                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                        <div class="layui-timeline-content layui-text">
                                            <h3 class="layui-timeline-title">END</h3>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
    {{--Hash地址的定位--}}
    var layid = location.hash.replace(/^#tabIndex=/, '');
    if (layid == "") {
        element.tabChange('tabAbout', 1);
    }
    {{--切换--}}
    element.tabChange('tabAbout', layid);
    {{--更改hash--}}
    element.on('tab(tabAbout)', function (elem) {
        location.hash = 'tabIndex=' + $(this).attr('lay-id');
    });
</script>
@endsection