{{--继承模板--}}
@extends('Home.Public.public')
{{--设置title--}}
@section('title', $blogInfo->name.'-'.$info->title)
{{--设置关键字--}}
@section('keywords', $keyWordsInfo->label)
{{--设置描述--}}
@section('description', $descriptionInfo->label)
{{--引入css文件--}}
@section('loadCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/prettify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/detail.css') }}">
@endsection
{{--body内容--}}
@section('body')
    {{--主体（一般只改变这里的内容）--}}
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="{{url('/')}}" title="网站首页">网站首页</a>
                <a href="{{url('/Article')}}" title="文章专栏">文章专栏</a>
                <a><cite>{{$info->title}}</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="blog-main-left">
                    {{--文章内容（使用百度编辑器发表的）--}}
                    <div class="article-detail shadow">
                        {!! $info->content !!}
                    </div>
                    {{--评论区域--}}
                    <div class="blog-module shadow" style="box-shadow: 0 1px 8px #a6a6a6;">
                        <fieldset class="layui-elem-field layui-field-title" style="margin-bottom:0">
                            <legend>来说两句吧</legend>
                            <div class="layui-field-box">
                                <form class="layui-form blog-editor" action="" id="commentForm">
                                    <input type="hidden" name="articleId" value="{{$info->id}}" />
                                    <div class="layui-form-item">
                                        <textarea name="editorContent" lay-verify="content" id="remarkEditor" placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                    </div>
                                    <div class="layui-form-item">
                                        <button class="layui-btn @php echo $isLogin===false?'layui-btn-disabled':'' @endphp" @php echo $isLogin===false?'disabled':'' @endphp lay-submit="formRemark" lay-filter="formRemark">@php echo $isLogin===false?'请先登录':'提交评论' @endphp</button>
                                    </div>
                                </form>
                            </div>
                        </fieldset>
                        <div class="blog-module-title">最新评论</div>
                        <ul class="blog-comment" id="commentList">

                        </ul>
                    </div>
                </div>
                <div class="blog-main-right">
                    {{--右边悬浮 平板或手机设备显示--}}
                    <div class="category-toggle"><i class="fa fa-chevron-left"></i></div>{{--这个div位置不能改，否则需要添加一个div来代替它或者修改样式表--}}
                    <div class="article-category shadow">
                        <div class="article-category-title">分类导航</div>
                        {{--点击分类后的页面和artile.html页面一样，只是数据是某一类别的--}}
                        @foreach($categoryList as $key => $value)
                            <a  href="{{url('/Category/'.$value->id)}}">
                                {{$value->name}}
                            </a>
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    <div class="blog-module shadow">
                        <div class="blog-module-title">相似文章</div>
                        <ul class="fa-ul blog-module-ul">
                            @foreach($xiangshiList as $key => $value)
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
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@endsection
{{--引入js文件--}}
@section('loadScript')
    <script src="{{ asset('Home/js/prettify.js') }}"></script>
    <script src="{{ asset('Home/js/detail.js') }}"></script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        flow.load({
            elem: '#commentList',
            isLazyimg:true,
            done: function(page, next){
                var lis = [];
                $.get('/getArticleComment/{{$info->id}}?page='+page, function(res){
                    layui.each(res.data, function(index, item){
                        var str ='<li>';
                        str+=   '<div class="comment-parent">'
                        str+=         '<img src="'+item.user_head+'" />'
                        str+=         '<div class="info">'
                        str+=            '<span class="username">'+item.user_account+'</span>'
                        str+=            '<span class="time">'+date("Y-m-d H:i",item.time)+'</span>'
                        str+=         '</div>'
                        str+=         '<div class="content">'
                        str+=            item.connect
                        str+=         '</div>'
                        str+=   '</div>'
                        str+='</li>'
                        lis.push(str);
                    });
                    next(lis.join(''), page < res.pageCount);
                },'json');
            }
        });
        $(function(){
            var img_max_width = $('.article-detail').width();
            $('.article-detail').find('img').each(function(){
                var img_width  = $(this).width();
                var img_heigth = $(this).height();
                if (img_width>img_max_width) {
                    $(this).attr('width',img_max_width);
                    var bili = img_width/img_heigth;
                    var img_max_height = Math.round(img_max_width/bili);
                    $(this).attr('height',img_max_height);
                };
            })
        })
        //浏览器窗口绑定resize事件,浏览器窗口大小改变，重新设置iframe高度
        $(window).on('resize',function(){
            var img_max_width = $('.article-detail').width();
            $('.article-detail').find('img').each(function(){
                var img_width  = $(this).width();
                var img_heigth = $(this).height();
                if (img_width>img_max_width) {
                    $(this).attr('width',img_max_width);
                    var bili = img_width/img_heigth;
                    var img_max_height = Math.round(img_max_width/bili);
                    $(this).attr('height',img_max_height);
                };
            });
        });
        $('.article-detail').find('img').click(function(){
            var width = $(window).width()*0.7;
            layer.open({
                type: 1,
                area:width+'px',
                title: false,
                closeBtn: 0,
                shadeClose: true,
                content: '<img style="width:'+width+'px;" src="'+$(this).attr('src')+'"/>'
            });
        });
    </script>
@endsection