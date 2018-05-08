{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.' - '.$blogInfo->introduce)
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
{{--引入css文件--}}
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/home.css') }}">
@endsection
{{--style样式--}}
@section('style')
    <style type="text/css">
        .layui-flow-more a:hover {color:#009688 !important;}
    </style>
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        {{--canvas--}}
        <canvas id="canvas-banner" style="background: #393D49;"></canvas>
        {{--为了及时效果需要立即设置canvas宽高，否则就在home.js中设置--}}
        <script type="text/javascript">
            var canvas = document.getElementById('canvas-banner');
            canvas.width = window.document.body.clientWidth - 10;//减去滚动条的宽度
            if (screen.width >= 992) {
                canvas.height = window.innerHeight * 1 / 3;
            } else {
                canvas.height = window.innerHeight * 2 / 7;
            }
        </script>
        {{--这个一般才是真正的主体内容--}}
        <div class="blog-container">
            <div class="blog-main">
                {{--网站公告提示--}}
                <div class="home-tips shadow">
                    <i style="float:left;line-height:17px;" class="fa fa-volume-up"></i>
                    <div class="home-tips-container">
                        @foreach($noticeList as $key =>$value)
                           <span style="color: #009688">
                               {{showUEditorContent($value->content)}}
                           </span>
                        @endforeach
                    </div>
                </div>
                {{--左边文章列表--}}
                <div class="blog-main-left" id="leftArticleList">
                </div>
                {{--右边小栏目--}}
                <div class="blog-main-right">
                    <div class="blogerinfo shadow">
                        <div class="blogerinfo-figure">
                            <img src="{{ asset('uploads').'/'.$bloggerInfo->img }}" alt="{{$bloggerInfo->name}}" style="width:100px;height: 100px;"/>
                        </div>
                        <p class="blogerinfo-nickname">{{$bloggerInfo->name}}</p>
                        <p class="blogerinfo-introduce">{{$bloggerInfo->introduce}}</p>
                        <p class="blogerinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;{{$bloggerInfo->label}}</p>
                        <hr />
                        <div class="blogerinfo-contact">
                            <a target="_blank" title="QQ交流" href="http://wpa.qq.com/msgrd?v=3&uin=248187189&site=qq&menu=yes"><i class="fa fa-qq fa-2x"></i></a>
                            <a target="_blank" title="给我写信" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=CTs9MTgxPjgxMEl4eCdqZmQ"><i class="fa fa-envelope fa-2x"></i></a>
                            <a target="_blank" title="新浪微博" href="https://weibo.com/p/1005055901114781/home?from=page_100505&mod=TAB#place"><i class="fa fa-weibo fa-2x"></i></a>
                            <a target="_blank" title="Github" href="https://github.com/xp248187189"><i class="fa fa-git fa-2x"></i></a>
                        </div>
                    </div>
                    <div></div>{{--占位--}}
                    <div class="blog-module shadow">
                        <div class="blog-module-title">作者推荐</div>
                        <ul class="fa-ul blog-module-ul">
                            @foreach($isRecommendList as $key => $value)
                                <li>
                                    <i class="fa-li fa fa-hand-o-right"></i>
                                    <a href="{{url('/Detail/'.$value->id)}}">
                                        {{$value->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">最新发表</div>
                        <ul class="fa-ul blog-module-ul">
                            @foreach($newestList as $key => $value)
                                <li>
                                    <i class="fa-li fa fa-hand-o-right"></i>
                                    <a href="{{url('/Detail/'.$value->id)}}">
                                        {{$value->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">一路走来</div>
                        <dl class="footprint">
                            @foreach($timeAxisList as $key => $value)
                                <dt>{{$value->year}}年@php echo $value->month>9?$value->month:'0'.$value->month @endphp月@php echo $value->day>9?$value->day:'0'.$value->day @endphp日</dt>
                                <dd>{{showUEditorContent($value->content)}}</dd>
                            @endforeach
                        </dl>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">网站推荐</div>
                        <ul class="blogroll">
                            @foreach($linkList as $key => $value)
                                <li>
                                    <a target="_blank" href="{{$value->url}}" title="{{$value->name}}">
                                        {{$value->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection
{{--引入js文件--}}
@section('loadScript')
    <script src="{{ asset('Home/js/home.js') }}"></script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        flow.load({
            elem: '#leftArticleList',
            end: '<a style="color:#777" href="{{url('/Article')}}">点我前往文章专栏查看更多</a>',
            isLazyimg:true,
            done: function(page, next){
                var lis = [];
                $.get('{{url('/getDataForIndex')}}'+'?page='+page, function(res){
                    layui.each(res.data, function(index, item){
                        var str ='<div class="article shadow">';
                        str+=	'<div class="article-left">'
                        str+=        '<img lay-src="{{asset('uploads')}}/'+item.img+'"/>'
                        str+=	'</div>'
                        str+=   '<div class="article-right">'
                        str+=		'<div class="article-title">'
                        str+=            '<a href="{{url('/Detail')}}/'+item.id+'">'+item.title+'</a>'
                        str+=       '</div>'
                        str+=       '<div class="article-abstract">'+item.outline+'</div>'
                        str+=	'</div>'
                        str+=   '<div class="clear"></div>'
                        str+=   '<div class="article-footer">'
                        str+=		'<span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;'+date("Y-m-d",item.addTime)+'</span>'
                        str+=		'<span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;'+item.author+'</span>'
                        str+=		'<span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="{{url('/Category')}}/'+item.category_id+'">'+item.category_name+'</a></span>'
                        str+=		'<span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;'+item.showNum+'</span>'
                        str+=		'<span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;'+item.commentCount+'</span>'
                        str+=	'</div>'
                        str+='</div>'
                        lis.push(str);
                    });
                    next(lis.join(''), page < res.pageCount);
                },'json');
            }
        });
    </script>
@endsection