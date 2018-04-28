{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '权限管理')
{{--body内容--}}
@section('body')
    <blockquote class="layui-elem-quote" id="nav_blockquote">
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm" onclick="add();">点击添加</button>
            <button class="layui-btn layui-btn-sm" onclick="delMore();">批量删除</button>
        </div>
        <div class="layui-inline">
            <form class="layui-form">
                <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="名称" style="width: 100px;">
                <button lay-submit lay-filter="search" class="layui-btn layui-btn-sm">搜索</button>
            </form>
        </div>
        <div class="layui-inline" id="queueStr"></div>
    </blockquote>
    <table id="dataTable" lay-filter="dataTable" lay-size="sm"></table>
    <script type="text/html" id="nameTemplet">
        @{{# if(d.level<2){ }}
        <a href="javascript:;" style="color:#01AAED;" onclick="nextLevel(@{{d.id}})">@{{d.name}}</a>
        @{{# }else{ }}
        <span>@{{ d.name }}</span>
        @{{# } }}
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
    </script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        var current_id = 0;
        var current_name = '根目录';
        var current_level = 0;
        var current_id_list = 0;
        var tableIns = table.render({
            elem: '#dataTable',
            id: 'dataTable',
            height: 'full-100',
            size: 'lg',
            page: true,
            limit:30,
            url: '{{ url('/myadmin/Auth/showList/getData') }}',
            method: 'post',
            where: {name:$('input[name="name"]').val()},
            cols:[[
                {type:'checkbox',fixed:'left'},
                {type:'numbers',fixed:'left',title:'序号'},
                {field:'name',title:'名称',sort:true,align:'center',templet:'#nameTemplet'},
                {field:'controller',title:'控制器',sort:true,align:'center'},
                {field:'action',title:'方法名',sort:true,align:'center'},
                {field:'sort',title:'排序',sort:true,align:'center'},
                {fixed:'right',title:'操作',align:'center',toolbar: '#barDemo'},
            ]],
            done:function(res, curr, count){
                $('#queueStr').html('当前目录：<a href="javascript:;" onclick="nextLevel(0)">根目录</a>'+res.queueStr);
                current_id = res.current.id;
                current_name = res.current.name;
                current_level = res.current.level;
                current_id_list = res.current.id_list;
            }
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
                    $.get('{{ url('/myadmin/Auth/ajaxDel') }}',{id:del_id},function(result){
                        layer.msg(result.echo);
                        if(result.state){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                        }
                    },'json');
                });
            }else if(layEvent === 'edit'){
                layer.open({
                    title:data.name,
                    type:2,
                    area:['800px', '450px'],
                    maxmin: true,
                    content: '@php echo url("myadmin/Auth/edit/'+data.id+'")@endphp',
                    end:function(){
                        tableIns.reload({
                            url: '@php echo url("myadmin/Auth/showList/getData/'+current_id+'")@endphp'
                        });
                    }
                });
            }
        });
        //监听搜索表单提交
        form.on('submit(search)', function(data) {
            tableIns.reload({
                where: data.field//data.field,当前容器的全部表单字段，名值对形式：{name: value}
            });
            return false;//阻止表单跳转。
        });
        //下一级
        function nextLevel(id){
            $('input[name="name"]').val('');
            tableIns.reload({
                where: {name:''},
                url: '@php echo url("myadmin/Auth/showList/getData/'+id+'")@endphp'
            });
        }
        //添加
        function add(){
            layer.open({
                title:current_name,
                type:2,
                area:['800px', '450px'],
                maxmin: true,
                content: '@php echo url("myadmin/Auth/add/'+current_id+'/'+current_level+'/'+current_id_list+'")@endphp',
                end:function(){
                    tableIns.reload({
                        url: '@php echo url("myadmin/Auth/showList/getData/'+current_id+'")@endphp'
                    });
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
                $.get('@php echo url("myadmin/Auth/ajaxDel")@endphp',{id:del_id},function(result){
                    layer.msg(result.echo);
                    if(result.state){
                        layer.close(index);
                        tableIns.reload({
                            where: {name:$('input[name="name"]').val()},
                        });
                    }
                },'json');
            });
        }
    </script>
@endsection