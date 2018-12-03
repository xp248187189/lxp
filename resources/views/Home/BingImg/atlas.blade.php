{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', cache('about_cache')[1]->name.' - 高清壁纸')
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/css/page.css') }}">
@endsection
{{--设置样式--}}
@section('style')
    <style>
        .timeline-box {
            background: #fff;
            padding: 8px;
            position: relative;
            min-height: 90vh;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a><cite>高清壁纸</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="timeline-box shadow">
                    <div class="layui-row" id="img_list">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        flow.load({
            elem: '#img_list', {{--指定列表容器--}}
            isLazyimg:false, {{--如果用懒加载，点快了的话相册弹窗会出问题--}}
            // end:' ',
            done: function(page, next){ {{--到达临界点（默认滚动触发），触发下一页--}}
                var lis = [];
                {{--以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）--}}
                $.get('/atlas/getData?page='+page, function(res){
                    {{--假设你的列表返回在data集合中--}}
                    layui.each(res.data, function(index, item){
                        lis.push('<div class="layui-col-sm3"><div style="padding: 10px;" class="img-partent"><img src="'+item.url+'" width="100%"></div></div>');
                    });
                    {{--执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页--}}
                    {{--pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多--}}
                    next(lis.join(''), page < res.pages);
                    layer.photos({
                        photos: '.img-partent',
                        anim: 5
                    });
                });
            }
        });
    </script>
@endsection