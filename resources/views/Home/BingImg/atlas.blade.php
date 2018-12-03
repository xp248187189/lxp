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
                    <div class="layui-row" id="layer-photos">
                        @foreach($data as $key => $value)
                        <div class="layui-col-sm3">
                            <div style="padding: 10px;">
                                <img lay-src="{{$value->url}}" width="100%">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{$data->links()}}
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        flow.lazyimg();
        layer.photos({
            photos: '#layer-photos',
            anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
    </script>
@endsection