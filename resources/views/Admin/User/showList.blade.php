{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '用户列表')
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
    <script type="text/html" id="statusTemplet">
        <form class="layui-form">
            @{{# var a= '';if(d.status==1){var a='checked';} }}
            <input type="checkbox" name="status" title="启用" value="@{{d.id}}" lay-filter="status" @{{a}}>
        </form>
    </script>
    <script type="text/html" id="imgDemo">
        <img style="height:40px;" src="@{{ d.head }}"/>
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
                url: '{{url("myadmin/User/showList/getData")}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {title:'加入日期',sort:true,align:'center',minWidth:'170',templet:'<div>@{{ date("Y-m-d H:i:s",d.addTime) }}</div>'},
                    {field:'account',title:'昵称',sort:true,align:'center',minWidth:'150',},
                    {field:'sex',title:'性别',sort:true,align:'center',minWidth:'80',},
                    {field:'head',title:'头像',sort:true,align:'center',minWidth:'100',event:'selImg',templet:'#imgDemo'},
                    {field:'connectid',title:'connectid',sort:true,align:'center',minWidth:'80',},
                    {field:'status',title:'状态',sort:true,align:'center',minWidth:'110',templet:'#statusTemplet'},
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
        //监听状态
        form.on('checkbox(status)', function(data){
            if (data.elem.checked){
                var statusVal = 1;
            }else{
                var statusVal = 0;
            }
            $.post('{{url("myadmin/User/ajaxEdit")}}',{id:data.value,status:statusVal},function(result){
                layer.msg(result.echo);
            },'json').error(function(){layer.msg('程序错误!');});
        });
        //监听工具条点击
        table.on('tool(dataTable)', function(obj) {
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值
            var tr = obj.tr; //获得当前行 tr 的DOM对象
            if(layEvent === 'selImg'){
                layer.open({
                    type: 1,
                    area:'500px',
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<img style="width:500px;" src="'+data.head+'"/>'
                });
            }
        });
    </script>
@endsection