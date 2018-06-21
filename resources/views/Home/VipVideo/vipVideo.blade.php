<!DOCTYPE html>
<html>
<head>
    <title>{{$blogInfo->name.' - vip视频解析'}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="keywords" content="{{$keyWordsInfo->label}}">
    <meta name="description" content="{{$descriptionInfo->label}}">
    {{--百度搜索资源平台(验证)--}}
    {{--<meta name="baidu-site-verification" content="hQ7PceVrnU" />--}}
    {{--Google Search Console(验证)--}}
    {{--<meta name="google-site-verification" content="blCIvm274GhkrcVqo36Y8LEdbTFA5OorGpJFFDmBnZg" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/layui/css/layui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Common/font-awesome/css/font-awesome.css') }}">
    {{--全局样式--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('Home/css/global.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="blog-container">
        <div class="blog-main">
            <fieldset class="layui-elem-field">
                <legend>VIP视频解析说明</legend>
                <div class="layui-field-box">
                    ①进入各大视频网站，找到想要观看的VIP视频，然后复制链接（浏览器上的视频地址）<br/><br/>
                    ②将复制的链接粘贴到本站播放地址，并点击开始解析<br/><br/>
                    ③等待解析完成，即可免费观看VIP视频<br/><br/>
                    ④如无法播放或者长时间无响应，请更换接口线路
                </div>
            </fieldset>
            <fieldset class="layui-elem-field">
                <legend>声明</legend>
                <div class="layui-field-box">
                    ①本站解析均源于互联网接口<br/><br/>
                    ②本站视频均源于互联网视频网站<br/><br/>
                    ③本站不进行任何资源存储<br/><br/>
                </div>
            </fieldset>
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-left: 0;">
                        <select id="api">
                            @foreach($vipVideoApi as $key => $value)
                                <option value="{{$value->url}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-left: 0;">
                        <input type="text" id="url" lay-verify="required" autocomplete="off" class="layui-input" placeholder="视频地址">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block" style="margin-left: 0;">
                        <input type="button" class="layui-btn layui-btn-fluid" value="开始解析" onclick="seeVip();">
                    </div>
                </div>
            </form>

            <fieldset class="layui-elem-field layui-field-title">
                <legend>下面是博主记录的一些视频，可直接观看</legend>
                <div class="layui-field-box">
                    <form class="layui-form" id="searchForm">
                        <div class="layui-form-item">
                            <div class="layui-input-block" style="margin-left: 0;">
                                <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="关键字搜索" >
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block" style="margin-left: 0;">
                                <button lay-submit lay-filter="search" class="layui-btn layui-btn-fluid">搜索</button>
                            </div>
                        </div>
                    </form>

                    <table id="dataTable" lay-filter="dataTable" lay-size="sm"></table>
                    <script type="text/html" id="barDemo">
                        <a class="layui-btn layui-btn-sm layui-btn-fluid" lay-event="see">GO</a>
                    </script>
                </div>
            </fieldset>
        </div>
    </div>
    <script src="{{ asset('Common/layui/layui.all.js') }}"></script>
    <script src="{{ asset('Common/layui/layuiGlobal.js') }}"></script>
    <script src="{{ asset('Common/js/functions.js') }}"></script>
    {{--<script src="{{ asset('Home/js/global.js') }}"></script>--}}
<script type="text/javascript">
    function seeVip() {
        var api = $.trim($('#api').val());
        var url = $.trim($('#url').val());
        if (url == ''){
            layer.msg('请输入url地址');
            return false;
        }
        window.open(api+url);
    }
    getDataTable();
    function getDataTable(){
        var searchFormData = getFormData("searchForm");
        table.render({
            elem: '#dataTable',
            id: 'dataTable',
            size: 'lg',
            page: true,
            limit:10,
            url: '{{url("/vip/getData")}}',
            method: 'get',
            where: searchFormData,
            cols:[[
                {field:'name',title:'名称',align:'left',width:'78%'},
                {fixed:'right',title:'观看',align:'center',toolbar: '#barDemo',width:'22%',minWidth:'100'},
            ]]
        });
    }
    form.on('submit(search)', function(data) {
        getDataTable();
        return false;{{--阻止表单跳转。--}}
    });
    table.on('tool(dataTable)', function(obj) {
        var data = obj.data;
        var layEvent = obj.event;
        if(layEvent === 'see') {
            var api = $('#api').val();
            window.open(api+data.url);
        }
    });
</script>
</body>
</html>