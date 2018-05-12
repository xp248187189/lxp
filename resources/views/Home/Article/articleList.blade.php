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

                </div>
                <div class="blog-main-right">
                    <div class="blog-search">
                        <form class="layui-form" action="/Search" id="searchForm">
                            <div class="layui-form-item">
                                <div class="search-keywords  shadow">
                                    <input type="text" name="keyWord" lay-verify="required" placeholder="输入关键词搜索" autocomplete="off" class="layui-input" value="{{$keyWord}}">
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
        form.on('submit(formSearch)', function(data){
            window.location.href="{{url('/')}}/Search/"+$('input[name="keyWord"]').val();
            return false;
        });
        flow.load({
            elem: '#leftArticleList',
            isLazyimg:true,
            done: function(page, next){
                    @php
                        echo 'var keyWord="'.(!empty($keyWord)?$keyWord:'0').'";';
                        echo 'var category='.(!empty($category)?$category:'0').';';
                    @endphp
                var lis = [];
                $.get('{{url('/getData')}}/'+keyWord+'/'+category+'?page='+page, function(res){
                    if (res.pageCount == 0) {
                        lis.push('<div class="shadow" style="text-align:center;font-size:16px;padding:40px 15px;background:#fff;margin-bottom:15px;">未找到有关的文章，随便看看吧</div>');
                    };
                    layui.each(res.data, function(index, item){
                        var str ='<div class="article shadow">';
                        str+=   '<div class="article-left">'
                        str+=        '<img lay-src="{{asset('uploads')}}/'+item.img+'"/>'
                        str+=   '</div>'
                        str+=   '<div class="article-right">'
                        str+=       '<div class="article-title">'
                        str+=            '<a href="{{url('/Detail')}}/'+item.id+'">'+item.title+'</a>'
                        str+=       '</div>'
                        str+=       '<div class="article-abstract">'+item.outline+'</div>'
                        str+=   '</div>'
                        str+=   '<div class="clear"></div>'
                        str+=   '<div class="article-footer">'
                        str+=       '<span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;'+date("Y-m-d",item.addTime)+'</span>'
                        str+=       '<span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;'+item.author+'</span>'
                        str+=       '<span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a href="{{url('/Category')}}/'+item.category_id+'">'+item.category_name+'</a></span>'
                        str+=       '<span class="article-viewinfo"><i class="fa fa-eye"></i>&nbsp;'+item.showNum+'</span>'
                        str+=       '<span class="article-viewinfo"><i class="fa fa-commenting"></i>&nbsp;'+item.commentCount+'</span>'
                        str+=   '</div>'
                        str+='</div>'
                        lis.push(str);
                    });
                    next(lis.join(''), page < res.pageCount);
                },'json');
            }
        });
    </script>
@endsection