{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '后台登录列表')
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
                url: '{{url("/AdminLogin/showList/getData")}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {field:'ip',title:'ip地址',align:'center',minWidth:'100'},
                    {field:'time',title:'时间',sort:true,align:'center',minWidth:'100',templet:'<div>@{{ date("Y-m-d H:i:s",d.time) }}</div>'},
                    {field:'account',title:'登录名',sort:true,align:'center',minWidth:'100'},
                    {field:'browser',title:'浏览器信息',minWidth:'300'},
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
                $.post('{{url("/AdminLogin/ajaxDel")}}',{id:del_id},function(result){
                    layer.msg(result.echo);
                    if(result.status){
                        layer.close(index);
                        $('#searchForm')[0].reset();
                        form.render();
                        getDataTable();
                    }
                },'json').error(function(result){
                    layer.close(index);
                    if (result.responseJSON.echo){
                        layer.msg(result.responseJSON.echo);
                    }else{
                        layer.msg('程序错误!');
                    }
                });
            });
        }
    </script>
@endsection