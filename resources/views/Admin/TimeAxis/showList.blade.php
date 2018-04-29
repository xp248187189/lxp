{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '时间轴列表')
{{--body内容--}}
@section('body')
    <blockquote class="layui-elem-quote" id="nav_blockquote">
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm" onclick="add();">点击添加</button>
            <button class="layui-btn layui-btn-sm" onclick="delMore();">批量删除</button>
        </div>
        <div class="layui-inline">
            <form class="layui-form" id="searchForm">
                <input type="text" name="startTime" id="startTime" autocomplete="off" class="layui-input" placeholder="开始日期" style="width: 100px;">-
                <input type="text" name="endTime" id="endTime" autocomplete="off" class="layui-input" placeholder="结束日期" style="width: 100px;">
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
    <script type="text/html" id="isHomeTemplet">
        <form class="layui-form">
            @{{# var a= '';if(d.isHome==1){var a='checked';} }}
            <input type="checkbox" name="isHome" title="是" value="@{{d.id}}" lay-filter="isHome" @{{a}}>
        </form>
    </script>
    <script type="text/html" id="timeTemplet">
        @{{ d.year+'-'+d.month+'-'+d.day+' '+d.hour+':'+d.minute }}
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
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
                url: '{{url("myadmin/TimeAxis/showList/getData")}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {title:'日期',sort:true,minWidth:'170',align:'center',templet:'#timeTemplet'},
                    {title:'内容',align:'left',minWidth:'250',templet:'<div>@{{ d.content }}</div>'},
                    {field:'status',title:'状态',minWidth:'110',sort:true,align:'center',templet:'#statusTemplet'},
                    {field:'isHome',title:'首页显示',minWidth:'110',sort:true,align:'center',templet:'#isHomeTemplet'},
                    {fixed:'right',title:'操作',minWidth:'150',align:'center',toolbar: '#barDemo'},
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
            $.post('{{url("myadmin/TimeAxis/ajaxEdit")}}',{id:data.value,status:statusVal},function(result){
                layer.msg(result.echo);
            },'json').error(function(){layer.msg('程序错误!');});
        });
        //监听首页显示
        form.on('checkbox(isHome)', function(data){
            if (data.elem.checked){
                var isHomeVal = 1;
            }else{
                var isHomeVal = 0;
            }
            $.post('{{url("myadmin/TimeAxis/ajaxEdit")}}',{id:data.value,isHome:isHomeVal},function(result){
                layer.msg(result.echo);
            },'json').error(function(){layer.msg('程序错误!');});
        });
        //监听单元格编辑
        table.on('edit(dataTable)', function(obj){
            //console.log(obj.value); //得到修改后的值
            //console.log(obj.field); //当前编辑的字段名
            //console.log(obj.data); //所在行的所有相关数据  
            var data = {};
            data['id'] = obj.data.id;
            data[obj.field] = obj.value;
            $.post('{{url("myadmin/TimeAxis/ajaxEdit")}}',data,function(result){
                layer.msg(result.echo);
            },'json');
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
                    $.get('{{url("myadmin/TimeAxis/ajaxDel")}}',{id:del_id},function(result){
                        layer.msg(result.echo);
                        if(result.status){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                        }
                    },'json');
                });
            }else if(layEvent === 'edit'){
                layer.open({
                    title:data.year+'-'+data.month+'-'+data.day+' '+data.hour+':'+data.minute,
                    type:2,
                    area:['990px', '450px'],
                    maxmin: true,
                    content: '@php echo url("myadmin/TimeAxis/edit/'+data.id+'")@endphp',
                    end:function(){
                        $('#searchForm')[0].reset();
                        form.render();
                        getDataTable();
                    }
                });
            }
        });
        //添加
        function add(){
            layer.open({
                title:'添加',
                type:2,
                area:['990px', '450px'],
                maxmin: true,
                content: '{{url("myadmin/TimeAxis/add")}}',
                end:function(){
                    $('#searchForm')[0].reset();
                    form.render();
                    getDataTable();
                }
            });
        }
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
                $.get('{{url("myadmin/TimeAxis/ajaxDel")}}',{id:del_id},function(result){
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