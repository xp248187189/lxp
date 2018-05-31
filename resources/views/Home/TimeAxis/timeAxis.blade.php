{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.' - 点点滴滴')
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
{{--引入css文件--}}
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/timeline.css') }}">
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a><cite>点点滴滴</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="timeline-box shadow">
                    <div class="timeline-main">
                        <h1><i class="fa fa-clock-o"></i>时光轴<span> —— 记录生活点点滴滴</span></h1>
                        <div class="timeline-line"></div>
                        @foreach($timeAxisList as $k => $v)
                        <div class="timeline-year">
                            <h2><a class="yearToggle" href="javascript:;">{{$k}}年</a><i class="fa fa-caret-down fa-fw"></i></h2>
                            @foreach($v as $kk => $vv)
                            <div class="timeline-month">
                                <h3 class=" animated fadeInLeft"><a class="monthToggle" href="javascript:;">@php echo $kk>9?$kk:'0'.$kk @endphp月</a><i class="fa fa-caret-down fa-fw"></i></h3>
                                <ul>
                                    @foreach($vv as $kkk => $vvv)
                                    <li class=" ">
                                        <div class="h4  animated fadeInLeft">
                                            <p class="date">@php echo $kk>9?$kk:'0'.$kk @endphp月@php echo $vvv['day']>9?$vvv['day']:'0'.$vvv['day'] @endphp日 @php echo $vvv['hour']>9?$vvv['hour']:'0'.$vvv['hour'] @endphp:@php echo $vvv['minute']>9?$vvv['minute']:'0'.$vvv['minute'] @endphp</p>
                                        </div>
                                        <p class="dot-circle animated "><i class="fa fa-dot-circle-o"></i></p>
                                        <div class="content animated fadeInRight">{!! $vvv['content'] !!}</div>
                                        <div class="clear"></div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        <h1 style="padding-top:4px;padding-bottom:2px;margin-top:40px;"><i class="fa fa-hourglass-end"></i>THE END</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        $(function () {
            $('.monthToggle').click(function () {
                $(this).parent('h3').siblings('ul').slideToggle('slow');
                $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
            });
            $('.yearToggle').click(function () {
                $(this).parent('h2').siblings('.timeline-month').slideToggle('slow');
                $(this).siblings('i').toggleClass('fa-caret-down fa-caret-right');
            });
        });
    </script>
@endsection