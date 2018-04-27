{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '首页')
{{--style样式--}}
@section('style')
    <style type="text/css">
        .ht-box {
            display: inline-block;
            margin: 15px;
            padding: 15px 0;
            color: #fff;
            width: 12%;
        }
        .ht-box p:first-child {
            font-size: 40px;
        }
        body{
            text-align: center;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
        @if($lastLoginInfo->count()==2)
            上次登陆
            <span style="padding-left:1em;">IP：{{$lastLoginInfo[1]->ip}}</span>
            <span style="padding-left:1em;">地点：{{$lastLoginInfo[1]->province.$lastLoginInfo[1]->city}}</span>
            <span style="padding-left:1em;">时间：{{date('Y-m-d H:i',$lastLoginInfo[1]->time)}}</span>
        @else
            未查到您上一次登陆信息，也许您是第一次登陆
        @endif
    </p>
    <fieldset class="layui-elem-field layui-field-title">
        <legend>统计信息</legend>
        <div class="layui-field-box">
            <div style="display: inline-block; width: 100%;">
                <div class="ht-box layui-bg-blue">
                    <p>{{$userCount}}</p>
                    <p>用户总数</p>
                </div>
                <div class="ht-box layui-bg-red">
                    <p>{{$today_add}}</p>
                    <p>今日注册</p>
                </div>
                <div class="ht-box layui-bg-green">
                    <p>{{$today_login}}</p>
                    <p>今日登陆</p>
                </div>
                <div class="ht-box layui-bg-orange">
                    <p>{{$articleCount}}</p>
                    <p>文章总数</p>
                </div>
            </div>
        </div>
    </fieldset>
@endsection