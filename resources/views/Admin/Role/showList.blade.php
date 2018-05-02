{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '角色管理')
{{--body内容--}}
@section('body')
    <blockquote class="layui-elem-quote" id="nav_blockquote">
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm" onclick="add();">点击添加</button>
            {{--<button class="layui-btn layui-btn-sm" onclick="delMore();">批量删除</button>--}}
        </div>
        <div class="layui-inline">
            <form class="layui-form" id="searchForm">
                <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="名称" style="width: 100px;">
                <button lay-submit lay-filter="search" class="layui-btn layui-btn-sm">搜索</button>
            </form>
        </div>
        <div class="layui-inline" id="queueStr"></div>
    </blockquote>
    <table id="dataTable" lay-filter="dataTable" lay-size="sm"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
    </script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        getDataTable();
        var tableIns;
        //加载数据表格
        function getDataTable(){
            var searchFormData = getFormData("searchForm");
            tableIns = table.render({
                elem: '#dataTable',
                id: 'dataTable',
                height: 'full-100',
                size: 'lg',
                page: true,
                limit:30,
                url: '{{url("myadmin/Role/showList/getData")}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {field:'name',title:'名称',edit:'text',sort:true,align:'center'},
                    {field:'sort',title:'排序',edit:'text',sort:true,align:'center'},
                    {fixed:'right',title:'操作',align:'center',toolbar: '#barDemo'},
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
        //监听单元格编辑
        table.on('edit(dataTable)', function(obj){
            //console.log(obj.value); //得到修改后的值
            //console.log(obj.field); //当前编辑的字段名
            //console.log(obj.data); //所在行的所有相关数据
            var data = {};
            data['id'] = obj.data.id;
            data[obj.field] = obj.value;
            $.post('{{url("myadmin/Role/ajaxEdit")}}',data,function(result){
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
                    $.get('{{url("myadmin/Role/ajaxDel")}}',{id:del_id},function(result){
                        layer.msg(result.echo);
                        if(result.status){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
                        }
                    },'json');
                });
            }else if(layEvent === 'edit'){
                layer.open({
                    title:data.name,
                    type:2,
                    area:['700px', '450px'],
                    maxmin: true,
                    content: '@php echo url("myadmin/Role/edit/'+data.id+'")@endphp',
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
                area:['700px', '450px'],
                maxmin: true,
                content: '{{url("myadmin/Role/add")}}',
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
                $.get('{{url("myadmin/Role/ajaxDel")}}',{id:del_id},function(result){
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