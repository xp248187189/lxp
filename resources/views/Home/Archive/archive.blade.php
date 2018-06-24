{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.' - 文章归档')
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
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
                <a><cite>文章归档</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="timeline-box shadow">
                    <ul class="layui-timeline">
                        @foreach($archiveList as $key => $value)
                        <li class="layui-timeline-item">
                            <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                            <div class="layui-timeline-content layui-text">
                                <h3 class="layui-timeline-title">{{$key}} ({{count($value)}}篇)</h3>
                                @foreach($value as $k => $v)
                                    <p><a target="_blank" href="{{url('/Detail/'.$v['id'])}}">{{$v['addDate']}}&nbsp;&nbsp;&nbsp;{{$v['title']}}</a></p>
                                @endforeach
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
@endsection