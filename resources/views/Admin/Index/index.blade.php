{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', 'MyBlog 后台管理系统')
{{--style样式--}}
@section('style')
	<style type="text/css">
		/**
		 * 隐藏第一个选项卡的删除符号
		 */
		.layui-tab-title li:first-child i {
			display: none;
		}
        /**
         * 锁屏弹出窗样式
         */
        .admin-header-lock {
            width: 320px;
            height: 170px;
            padding: 20px;
            position: relative;
            text-align: center;
        }
        .admin-header-lock-img {
            width: 70px;
            height: 70px;
            margin: 0 auto;
        }
        .admin-header-lock-name {
            color: #009688;
            margin: 8px 0 15px 0;
        }
        .input_btn {
            overflow: hidden;
            margin-bottom: 10px;
        }
        #lock-box p {
            color: #e60000;
        }
        .admin-header-lock-input {
            width: 170px;
            color: #fff;
            background-color: #009688;
            float: left;
            margin: 0 10px 0 40px;
            border: none;
        }
        input::-webkit-input-placeholder {
            color: #fff;
        }
        #unlock {
            float: left;
        }
        .admin-header-lock-img img {
            width: 70px;
            height: 70px;
            border-radius: 100%;
            box-shadow: 0 0 30px #44576b;
        }
	</style>
@endsection
{{--body内容--}}
@section('body')
	<!--所有内容-->
	<div class="layui-layout layui-layout-admin">
		<!--顶部-->
		<div class="layui-header">
			<div class="layui-logo" style="cursor:pointer" onclick="window.location.reload();"><h2 id="blogName">{{$blogInfo->name}}</h2></div>
			<ul class="layui-nav layui-layout-right" id="top_nav">
                <li class="layui-nav-item">
                    <a href="javascript:;" onclick="lockView();"><i class='fa fa-fw fa-lock'></i>锁屏</a>
                </li>
				<li class="layui-nav-item">
					<a href="javascript:;" id="adminInfoName">
						{{ session()->get('adminInfo')['name'] }}
					</a>
					<dl class="layui-nav-child">
                        <dd><a href="javascript:;" onclick="editMe();">基本资料</a></dd>
						<dd><a href="javascript:;" onclick="cacheFlush();">清空缓存</a></dd>
                        @if(session()->get('adminInfo')['id'] == 1)
                            <dd><a href="javascript:;" onclick="window.open('{{url('/Index/showPhpInfo')}}');">phpinfo</a></dd>
                        @endif
                        <dd><a href="javascript:;" onclick="signOut();">安全退出</a></dd>
					</dl>
				</li>
			</ul>
		</div>
		<!--侧边导航-->
		<div class="layui-side layui-bg-black">
			<div class="layui-side-scroll">
				<!-- 左侧导航区域（可配合layui已有的垂直导航） -->
				<ul class="layui-nav layui-nav-tree" lay-filter="leftnav" lay-shrink="all">
					<li class="layui-nav-item layui-this">
                        <a href="javascript:;" data-id="0" onclick="changIndex(0);"><i class="fa fa-fw fa-home"></i> <span>首页</span></a>
					</li>
                    @foreach ($authList as $key => $value)
					<li class="layui-nav-item">
						<a href="javascript:;">
                            @php echo empty($value['icon'])?'<i class="fa fa-fw fa-search"></i>':'<i class="fa fa-fw '.$value['icon'].'"></i>'@endphp <span>{{$value['name']}}</span>
						</a>
						<dl class="layui-nav-child">
                            @foreach ($value['s_authList'] as $k => $v)
							<dd>
								<a href="javascript:;" data-url="{{ url('/'.$v['controller'].'/'.$v['action']) }}" data-id="{{$v['id']}}">
                                    @php echo empty($v['icon'])?'<i class="fa fa-fw fa-search"></i>':'<i class="fa fa-fw '.$v['icon'].'"></i>';@endphp <span>{{$v['name']}}</span>
								</a>
							</dd>
                            @endforeach
						</dl>
					</li>
                    @endforeach
				</ul>
			</div>
		</div>
		<!--内容主体-->
		<div class="layui-body" style="overflow:-Scroll;overflow-y:hidden;bottom:0;">
			<div class="layui-tab layui-tab-brief" lay-filter="tab" lay-allowClose="true">
				<ul class="layui-tab-title">
					<li class="layui-this" lay-id="0">首页</li>
				</ul>
				<div class="layui-tab-content">
					<div class="layui-tab-item layui-show">
						<iframe id="indexIframe" src="{{ url('/Index/welcome') }}" frameborder="0" scrolling="yes" style="width:100%;border:none;outline:none;" onload="setIframeHeight(this)"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 右键菜单（第一个选项卡） -->
	<div style="display: none" id="three_menu_one">
		<table class="layui-tab" id="three_menu_table_one">
			<tr>
				<td td-click="1" style="cursor:pointer;height:30px;line-height:30px;padding:0 6px;"><i class="layui-icon">&#x1002;</i> 刷新当前标签</td>
			</tr>
			<tr>
				<td td-click="3" style="cursor:pointer;height:30px;line-height:30px;padding:0 6px;"><i class="layui-icon">&#x1006;</i> 关闭所有标签</td>
			</tr>
		</table>
	</div>
	<!-- 右键菜单（其他选项卡） -->
	<div style="display: none" id="three_menu">
		<table class="layui-tab" id="three_menu_table">
			<tr>
				<td td-click="1" style="cursor:pointer;height:30px;line-height:30px;padding:0 6px;"><i class="layui-icon">&#x1002;</i> 刷新当前标签</td>
			</tr>
			<tr>
				<td td-click="2" style="cursor:pointer;height:30px;line-height:30px;padding:0 6px;"><i class="layui-icon">&#x1006;</i> 关闭当前标签</td>
			</tr>
			<tr>
				<td td-click="3" style="cursor:pointer;height:30px;line-height:30px;padding:0 6px;"><i class="layui-icon">&#x1006;</i> 关闭所有标签</td>
			</tr>
		</table>
	</div>
@endsection
{{--js内容--}}
@section('script')
	<script type="text/javascript">
        //监听导航菜单的点击（只能监听二级菜单）
        element.on('nav(leftnav)', function(elem){
            // console.log(elem); //得到当前点击的DOM对象
            // 获取左侧导航的一些属性
            // var url = $(elem).children('a').attr('data-url');   //页面url
            // var id = $(elem).children('a').attr('data-id');     //tab唯一Id
            // var title = $(elem).children('a').children('span').text();           //菜单名称
            var url = $(elem).attr('data-url');   //页面url
            var id = $(elem).attr('data-id');     //tab唯一Id
            var title = $(elem).children('span').text();           //菜单名称
            if(title == "首页"){
                element.tabChange('tab',0);
                return;
            }
            if(url == undefined){
                return;
            }
            //判断tab是否存在，存在就切换到对应tab，不存在则创建
            var tab_ul = $('.layui-tab[lay-filter=\'tab\']').children('.layui-tab-title');
            var exist = tab_ul.find('li[lay-id=' + id + ']');
            if (exist.length > 0) {
                //存在，切换到对应tab
                element.tabChange('tab',id);
            }else{
                //不存在，创建tab
                //加载动画
                var index = layer.load(1);
                //创建tab
                var height = $(document).height()-101;//获取高度
                var iframeId = new Date().getTime();
                element.tabAdd('tab', {
                    title: title,
                    content: '<iframe id="'+iframeId+'" src="'+url+'" frameborder="0" scrolling="yes" style="height:'+height+'px;width:100%;border:none;outline:none;"></iframe>',
                    id: id
                });
                //切换到指定索引的卡片
                element.tabChange('tab', id);
                //iframe加载完成关闭加载动画
                iframeOnLoadDoing(iframeId,function(){
                    //关闭加载动画
                    layer.close(index);
                });
            }
        });
        // 点击body关闭tips
        $(document).on('click', 'html', function () {
            layer.closeAll('tips');
        });
        //阻止浏览器默认右键点击事件
        $(document).on("contextmenu", '.layui-tab-title li', function () {
            return false;
        });
        //选项卡右击事件
        var cardIdx,cardLayId;
        $(document).on("mousedown", '.layui-tab-title li', function (e) {
            if (3 == e.which && $(this).attr('lay-id') == 0) {
                //第一个选项卡
                cardIdx = $(this).index();
                cardLayId = $(this).attr('lay-id');
                layer.tips($('#three_menu_one').html(), $(this), {
                    tips: [3,'#78BA32'],
                    time: false
                });
            }else if(3 == e.which && $(this).attr('lay-id') != 0){
                //其他选项卡
                cardIdx = $(this).index();
                cardLayId = $(this).attr('lay-id');
                layer.tips($('#three_menu').html(), $(this), {
                    tips: [3,'#78BA32'],
                    time: false
                });
            }
        });
        //右键菜单点击事件(第一个选项卡)
        $(document).on('click', '#three_menu_table_one td', function () {
            var td_click = $(this).attr('td-click');
            if (td_click==1) {
                //刷新当前标签
                // 窗体对象
                var ifr = $(document).find('.layui-tab-item>iframe').eq(cardIdx);
                // 刷新当前页
                ifr.attr('src', ifr.attr('src'));
                // 切换到当前选项卡
                element.tabChange('tab',cardLayId);
            }else{
                //关闭全部标签
                $('.layui-tab-title li').each(function(k,v){
                    var lay_id = $(v).attr('lay-id');
                    if(lay_id != 0){
                        element.tabDelete('tab',lay_id);
                    }
                })
            }
        });
        //右键菜单点击事件(其他选项卡)
        $(document).on('click', '#three_menu_table td', function () {
            var td_click = $(this).attr('td-click');
            if (td_click==1) {
                //刷新当前标签
                // 窗体对象
                var ifr = $(document).find('.layui-tab-item>iframe').eq(cardIdx);
                // 刷新当前页
                ifr.attr('src', ifr.attr('src'));
                // 切换到当前选项卡
                element.tabChange('tab',cardLayId);
            }else if(td_click==2){
                //关闭当前标签
                element.tabDelete('tab',cardLayId);
            }else{
                //关闭全部标签
                $('.layui-tab-title li').each(function(k,v){
                    var lay_id = $(v).attr('lay-id');
                    if(lay_id != 0){
                        element.tabDelete('tab',lay_id);
                    }
                })
            }
        });
        //设置iframe高度
        function setIframeHeight(obj){
            var height = $(document).height()-101;
            $(obj).attr('style','height:'+height+'px;width:100%;border:none;outline:none;');
        }
        //一级菜单切换
        function changIndex(lay_id){
            //把展开的左侧导航菜单关闭
            $('.layui-nav-tree li').attr('class','layui-nav-item');
            //切换到选项卡
            // element.tabChange('tab',lay_id);
        }
        //浏览器窗口绑定resize事件,浏览器窗口大小改变，重新设置iframe高度
        $(window).on('resize',function(){
            setIframeHeight('.layui-tab-item>iframe');
        });
        //个性化设置
        function custom(){
            var left = $(document).width()-250;
            var top = 60;
            layer.open({
                title:false,
                type: 1,
                closeBtn: 0,
                offset: [top+'px',left+'px'],
                area: '250px',
                content: '<div style="padding: 20px 80px;">内容</div>',
                shade: '0.0',
                shadeClose: true,
                end: function(){
                    $('#top_nav').find('.layui-this').removeClass('layui-this');
                }
            });
        }
        //修改个人资料
        function editMe(){
            layer.open({
                title:'修改个人资料',
                type: 2,
                area:['700px', '350px'],
                content: '{{ url('/Index/editMe') }}',
                end: function(){
                    $('#top_nav').find('.layui-this').removeClass('layui-this');
                }
            });
        }
        //退出
        function signOut(){
            layer.confirm('真的退出么', function(index) {
                $.get('{{ url('/doLogOut') }}',{},function(resule){
                    if (resule.status) {
                        window.location.href = "{{ url('/login') }}";
                    };
                },'json').error(function(result){
                    if (result.responseJSON.echo){
                        layer.msg(result.responseJSON.echo);
                    }else{
                        layer.msg('程序错误!');
                    }
                });
            });
        }

        //清空缓存
        function cacheFlush() {
            layer.confirm('确定清空前端缓存', function(index) {
                $.get('{{ url('/Index/cacheFlush') }}',{},function(resule){
                    layer.msg('清空成功');
                },'json').error(function(result){
                    if (result.responseJSON.echo){
                        layer.msg(result.responseJSON.echo);
                    }else{
                        layer.msg('程序错误!');
                    }
                });
            });
        }

        //锁屏
        function lockView() {
            //判断锁屏框是否已经弹出
            if ($('#lockUserName').length > 0){
                return false;
            }
            $.post('{{url('/Index/lockView')}}',{},function (result) {
                var str = '<div class="admin-header-lock" id="lock-box">';
                str+=   '<div class="admin-header-lock-img"><img src="{{asset('favicon.ico')}}"/></div>';
                str+=   '<div class="admin-header-lock-name" id="lockUserName">{{ session()->get('adminInfo')['name'] }}</div>';
                str+=   '<div class="input_btn">';
                str+=       '<input type="password" class="admin-header-lock-input layui-input" autocomplete="off" placeholder="请输入密码解锁.." name="lockPwd" id="lockPwd" />';
                str+=       '<button class="layui-btn" id="unlock">解锁</button>';
                str+=   '</div>';
                str+= '</div>';
                layer.open({
                    title : false,
                    type : 1,
                    content : str,
                    closeBtn : 0,
                    shade : 0.7
                });
                $(".admin-header-lock-input").focus();
            }).error(function(result){
                if (result.responseJSON.echo){
                    layer.msg(result.responseJSON.echo);
                }else{
                    layer.msg('程序错误!');
                }
            });
        }
        // 判断是否显示锁屏
        var isLockView = {{ $isLockView }};
        if (isLockView === 1){
            lockView();
        }
        // 解锁
        $("body").on("click","#unlock",function(){
            //锁定按钮
            $('#unlock').attr('disabled',true);
            if($(this).siblings(".admin-header-lock-input").val() == ''){
                layer.msg("请输入解锁密码！");
                $(this).siblings(".admin-header-lock-input").focus();
                //解锁按钮
                $('#unlock').attr("disabled",false);
            }else{
                layer.msg('验证中，请稍后...');
                $.post('{{url('/Index/checkPassWord')}}',{passWord:$(this).siblings(".admin-header-lock-input").val()},function (result) {
                    $(this).siblings(".admin-header-lock-input").val('');
                    if (result.status){
                        layer.msg('验证成功，正在为您解锁',function () {
                            layer.closeAll("page");
                        });
                    } else{
                        layer.msg("密码错误，请重新输入！");
                        $(this).siblings(".admin-header-lock-input").val('').focus();
                        //解锁按钮
                        $('#unlock').attr("disabled",false);
                    }
                }).error(function(result){
                    if (result.responseJSON.echo){
                        var retry_after = result.getResponseHeader('retry-after');
                        layer.msg('对不起！系统检测到您疑是恶意操作，请'+retry_after+'秒后再试！');
                    }else{
                        layer.msg('程序错误!');
                    }
                    //解锁按钮
                    $('#unlock').attr("disabled",false);
                });
            }
        });
        //回车解锁
        $(document).on('keydown', function(event) {
            var event = event || window.event;
            if(event.keyCode == 13) {
                $("#unlock").click();
            }
        });
        //每5秒判断一下是否锁定，避免多开
        window.setInterval(function () {
            $.post('{{url('/Index/checkIsLockView')}}',{},function (results) {
                if (results.isLockView == 1){
                    lockView();
                }else if (results.isLockView == 0){
                    if ($('#unlock').length > 0){
                        layer.closeAll("page");
                    }
                }
            });
        },5000);
	</script>
@endsection