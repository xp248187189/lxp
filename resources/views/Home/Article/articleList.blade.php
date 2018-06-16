{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.' - '.$titleName)
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
{{--引入css文件--}}
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/article.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a><cite>文章专栏</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="blog-main-left" id="leftArticleList">
                    @if($hasArticleList === false)
                        <div class="shadow" style="text-align:center;font-size:16px;padding:40px 15px;background:#fff;margin-bottom:15px;">
                            未找到有关的文章，随便看看吧
                        </div>
                    @endif
                    @foreach($articleList as $key => $value)
                        <div class="article shadow">
                            <div class="article-left">
                                <img src="{{asset('uploads/'.$value->img)}}"/>
                            </div>
                            <div class="article-right">
                                <div class="article-title">
                                    <a href="{{url('/Detail/'.$value->id)}}">{{$value->title}}</a>
                                </div>
                                <div class="article-abstract">
                                    {{$value->outline}}
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="article-footer">
                                <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;{{date('Y-m-d',$value->addTime)}}</span>
                                <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$value->author}}</span>
                                <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="{{url('/Category/'.$value->category_id)}}">{{$value->category_name}}</a></span>
                                <span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;{{$value->showNum}}</span>
                                <span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;{{$value->commentCount}}</span>
                            </div>
                        </div>
                    @endforeach
                    @if($hasArticleList)
                        {{ $articleList->links() }}
                    @endif
                </div>
                <div class="blog-main-right">
                    <div class="blog-search">
                        <form class="layui-form" action="/Search" id="searchForm">
                            <div class="layui-form-item">
                                <div class="search-keywords  shadow">
                                    <input type="text" name="keyWord" lay-verify="keyWord" placeholder="输入关键词搜索" autocomplete="off" class="layui-input" value="{{$keyWord}}">
                                </div>
                                <div class="search-submit  shadow">
                                    <a class="search-btn" lay-submit lay-filter="formSearch"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="article-category shadow">
                        <div class="article-category-title">分类导航</div>
                        @foreach($categoryList as $key => $value)
                            <a @php echo ($category==$value->id)?'style="border:1px solid #5FB878;color:#5FB878"':'';@endphp href="{{url('/Category/'.$value->id)}}">
                                {{$value->name}}
                            </a>
                        @endforeach
                        <div class="clear"></div>
                    </div>
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
                        <div class="blog-module-title">随便看看</div>
                        <ul class="fa-ul blog-module-ul">
                            @foreach($suijiList as $key => $value)
                                <li>
                                    <i class="fa-li fa fa-hand-o-right"></i>
                                    <a href="{{url('/Detail/'.$value->id)}}">
                                        {{$value->title}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--右边悬浮 平板或手机设备显示-->
                    <div class="category-toggle"><i class="fa fa-chevron-left"></i></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        {{--监听搜索框不能出现%和#--}}
        $('input[name="keyWord"]').bind('input propertychange', function() {
            var str = $(this).val();
            $(this).val(str.replace(/[%#]/g,''));
        });
        //回车事件
        document.onkeydown = function (event) {
            var e = event || window.event;
            if (e && e.keyCode == 13) { //回车键的键值为13
                if ($('input[name="keyWord"]').is(":focus")) {
                    $('.search-btn').click();
                };
                return false;
            }
        };
        form.verify({
            keyWord: [
                /[\S]+/
                ,'请输入关键词'
            ]
        });
        form.on('submit(formSearch)', function(data){
            window.location.href="{{url('/')}}/Search/"+$('input[name="keyWord"]').val();
            return false;
        });
    </script>
@endsection