{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.' - 关于本站')
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
{{--引入css文件--}}
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/about.css') }}">
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a><cite>关于本站</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="layui-tab layui-tab-brief shadow" lay-filter="tabAbout">
                    <ul class="layui-tab-title">
                        <li class="layui-this" lay-id="1">关于博客</li>
                        <li lay-id="2">关于作者</li>
                        <li lay-id="3" id="frinedlink">网站推荐</li>
                        <li lay-id="4">留言墙</li>
                    </ul>
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{asset('/Home/image/Logo_100.png')}}" alt="{{$blogInfo->name}}" />
                                </div>
                                <p class="aboutinfo-nickname">{{$blogInfo->name}}</p>
                                <p class="aboutinfo-introduce">{{$blogInfo->introduce}}</p>
                                <p class="aboutinfo-location"><i class="fa fa-link"></i>&nbsp;&nbsp;<a target="_blank" href="{{url('/')}}">{{url('/')}}</a></p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <a target="_blank" title="网站首页" href="{{url('/')}}"><i class="fa fa-home fa-2x" style="font-size:2.5em;position:relative;top:3px"></i></a>
                                    <a target="_blank" title="文章专栏" href="{{url('/Article')}}"><i class="fa fa-file-text fa-2x"></i></a>
                                    <a target="_blank" title="点点滴滴" href="{{url('/TimeAxis')}}"><i class="fa fa-hourglass-half fa-2x"></i></a>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>简介</legend>
                                    <div class="layui-field-box aboutinfo-abstract">
                                        {!! $blogInfo->detail !!}
                                        <h1 style="text-align:center;">The End</h1>
                                    </div>
                                </fieldset>
                            </div>
                        </div>{{--关于网站End--}}
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{ asset('uploads').'/'.$bloggerInfo->img }}" alt="{{$bloggerInfo->name}}" style="width:100px;height: 100px;"/>
                                </div>
                                <p class="aboutinfo-nickname">{{$bloggerInfo->name}}</p>
                                <p class="aboutinfo-introduce">{{$bloggerInfo->introduce}}</p>
                                <p class="aboutinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;{{$bloggerInfo->label}}</p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <a target="_blank" title="QQ交流" href="http://wpa.qq.com/msgrd?v=3&uin=248187189&site=qq&menu=yes"><i class="fa fa-qq fa-2x"></i></a>
                                    <a target="_blank" title="给我写信" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=CTs9MTgxPjgxMEl4eCdqZmQ"><i class="fa fa-envelope fa-2x"></i></a>
                                    <a target="_blank" title="新浪微博" href="https://weibo.com/p/1005055901114781/home?from=page_100505&mod=TAB#place"><i class="fa fa-weibo fa-2x"></i></a>
                                    <a target="_blank" title="Github" href="https://github.com/xp248187189"><i class="fa fa-git fa-2x"></i></a>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>简介</legend>
                                    <div class="layui-field-box aboutinfo-abstract abstract-bloger">
                                        {!! $bloggerInfo->detail !!}
                                        <h1 style="text-align:center;">The End</h1>
                                    </div>
                                </fieldset>
                            </div>
                        </div>{{--关于作者End--}}
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img width="100px" src="{{asset('/Home/image/recommend.png')}}" alt="网站推荐" />
                                </div>
                                <p class="aboutinfo-nickname">网站推荐</p>
                                <p class="aboutinfo-introduce">Name：{{$blogInfo->name}}&nbsp;&nbsp;&nbsp;&nbsp;Site：{{url('/')}}</p>
                                <p class="aboutinfo-location">
                                    <i class="fa fa-close"></i>经常宕机&nbsp;
                                    <i class="fa fa-close"></i>不合法规&nbsp;
                                    <i class="fa fa-close"></i>插边球站&nbsp;
                                    <i class="fa fa-close"></i>红标报毒&nbsp;
                                    <i class="fa fa-check"></i>原创优先&nbsp;
                                    <i class="fa fa-check"></i>技术优先
                                </p>
                                <hr />
                                <div class="aboutinfo-contact">
                                    <p style="font-size:2em;">优秀网站，个人推荐</p>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>Website Recommendation</legend>
                                    <div class="layui-field-box">
                                        <ul class="friendlink">
                                            @foreach($linkList as $key => $value)
                                            <li>
                                                <a target="_blank" href="{{$value->url}}" title="{{$value->name}}" class="friendlink-item">
                                                    <p class="friendlink-item-pic"><img src="{{$value->url}}/favicon.ico" alt="{{$value->name}}" /></p>
                                                    <p class="friendlink-item-title">{{$value->name}}</p>
                                                    <p class="friendlink-item-domain">{{$value->url}}</p>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </div>{{--网站推荐End--}}
                        <div class="layui-tab-item">
                            <div class="aboutinfo">
                                <div class="aboutinfo-figure">
                                    <img src="{{asset('/Home/image/messagewall.png')}}" alt="留言墙" />
                                </div>
                                <p class="aboutinfo-nickname">留言墙</p>
                                <p class="aboutinfo-introduce">本页面可留言、吐槽、提问。欢迎灌水，杜绝广告！</p>
                                <p class="aboutinfo-location">
                                    <i class="fa fa-clock-o"></i>&nbsp;<span id="time"></span>
                                </p>
                                <hr id="gt" />
                                <div class="aboutinfo-contact">
                                    <p style="font-size:2em;">沟通交流，拉近你我！</p>
                                </div>
                                <fieldset class="layui-elem-field layui-field-title">
                                    <legend>Leave a message</legend>
                                    <div class="layui-field-box">
                                        <div class="leavemessage" style="text-align:initial">
                                            <form class="layui-form blog-editor" action="" id="commentForm">
                                                <div class="layui-form-item">
                                                    <textarea name="editorContent" lay-verify="content" id="remarkEditor" placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                                </div>
                                                <div class="layui-form-item">
                                                    <button class="layui-btn @php echo $isLogin===false?'layui-btn-disabled':'' @endphp" @php echo $isLogin===false?'disabled':'' @endphp lay-submit="formLeaveMessage" lay-filter="formLeaveMessage">@php echo $isLogin===false?'请先登录':'提交评论' @endphp</button>
                                                </div>
                                            </form>
                                            <ul class="blog-comment" id="commentList">

                                            </ul>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>{{--留言墙End--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--引入js文件--}}
@section('loadScript')
    <script src="{{ asset('Home/js/about.js') }}"></script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        flow.load({
            elem: '#commentList',
            isLazyimg:true,
            done: function(page, next){
                var lis = [];
                $.get('/getUserComment?page='+page, function(res){
                    layui.each(res.data, function(index, item){
                        var str ='<li>';
                        str+=   '<div class="comment-parent">'
                        str+=         '<img src="'+item.user_head+'" />'
                        str+=         '<div class="info">'
                        str+=            '<span class="username">'+item.user_account+'</span>'
                        str+=         '</div>'
                        str+=         '<div class="content">'
                        str+=            item.connect
                        str+=         '</div>'
                        str+=         '<p class="info info-footer"><span class="time">'+date("Y-m-d H:i",item.time)+'</span><a class="btn-reply" href="javascript:;" onclick="btnReplyClick(\''+item.user_account+'\')">回复</a></p>'
                        str+=   '</div>'
                        str+='</li>'
                        lis.push(str);
                    });
                    next(lis.join(''), page < res.pageCount);
                },'json');
            }
        });
    </script>
@endsection