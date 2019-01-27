{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', cache('about_cache')[1]->name.' - 高清图集')
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
                <a><cite>高清图集</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="timeline-box shadow">
                    <div class="layui-row" id="img_list">
                        @if($hasBingImgList === false)
                            <div class="shadow" style="text-align:center;font-size:16px;padding:40px 15px;background:#fff;margin-bottom:15px;">
                                未找到有关的图集，随便看看吧
                            </div>
                        @endif
                        @foreach($bingImgList as $key => $value)
                            <div class="layui-col-sm3 img-partent" style="padding: 10px;">
                                <img src="{{$value->url}}" width="100%" date="{{$value->date}}"/>
                            </div>
                        @endforeach
                    </div>
                    @if($hasBingImgList)
                        <div style="text-align: center;">
                            {{ $bingImgList->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        layer.photos({
            photos: '.img-partent',
            anim: 5
        });
    </script>
@endsection