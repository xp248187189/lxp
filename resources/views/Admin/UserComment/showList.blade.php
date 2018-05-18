{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '文章评论列表')
{{--body内容--}}
@section('body')
    <blockquote class="layui-elem-quote" id="nav_blockquote">
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm" onclick="delMore();">批量删除</button>
        </div>
        <div class="layui-inline">
            <form class="layui-form" id="searchForm">
                <input type="text" name="startTime" id="startTime" autocomplete="off" class="layui-input" placeholder="开始日期" style="width: 100px;">-
                <input type="text" name="endTime" id="endTime" autocomplete="off" class="layui-input" placeholder="结束日期" style="width: 100px;">
                <input type="text" name="keyWord" autocomplete="off" class="layui-input" placeholder="关键字" style="width: 100px;">
                <button lay-submit lay-filter="search" class="layui-btn layui-btn-sm">搜索</button>
            </form>
        </div>
    </blockquote>
    <table id="dataTable" lay-filter="dataTable" lay-size="sm"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
    </script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        laydate.render({
            elem: '#startTime' //指定元素
        });
        laydate.render({
            elem: '#endTime' //指定元素
        });
        getDataTable();
        //加载数据表格
        function getDataTable(){
            var searchFormData = getFormData("searchForm");
            table.render({
                elem: '#dataTable',
                id: 'dataTable',
                height: 'full-100',
                size: 'lg',
                page: true,
                limit:30,
                url: '{{url('myadmin/UserComment/showList/getData')}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {field:'user_account',title:'用户昵称',align:'left',minWidth:'100'},
                    {field:'time',title:'时间',sort:true,align:'center',minWidth:'170',templet:'<div>@{{ date("Y-m-d H:i:s",d.time) }}</div>'},
                    {field:'connect',title:'内容',sort:true,align:'center',minWidth:'400',event:'detail'},
                    {fixed:'right',title:'操作',minWidth:'100',align:'center',toolbar: '#barDemo'},
                ]],
                done:function(res, curr, count){

                }
            });
        }
        //监听搜索表单提交
        form.on('submit(search)', function(data) {
            getDataTable();
            return false;//阻止表单跳转。
        });
        //监听工具条点击
        table.on('tool(dataTable)', function(obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            if(layEvent === 'del') {
                //删除
                layer.confirm('真的删除行么', function(index) {
                    var del_id = data.id;
                    $.get('{{url("myadmin/UserComment/ajaxDel")}}',{id:del_id},function(result){
                        layer.msg(result.echo);
                        if(result.status){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                        }
                    },'json');
                });
            }else if(layEvent === 'detail'){
                layer.open({
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    area: ['420px', '240px'],
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: data.connect
                });
            }
        });
        //批量删除
        function delMore(){
            var checkStatus = table.checkStatus('dataTable');//取得选中的数据对象
            if (checkStatus.data.length === 0) {//判断选中的数据的长度
                layer.msg('请选择要删除的数据');
                return;
            }
            layer.confirm('真的删除行么', function(index) {
                var del_id = '';
                layui.each(checkStatus.data, function(num, item) {
                    del_id += item.id+',';
                });
                del_id = del_id.substring(0,del_id.length-1);
                $.get('{{url("myadmin/UserComment/ajaxDel")}}',{id:del_id},function(result){
                    layer.msg(result.echo);
                    if(result.status){
                        layer.close(index);
                        $('#searchForm')[0].reset();
                        form.render();
                        getDataTable();
                    }
                },'json');
            });
        }
    </script>
@endsection