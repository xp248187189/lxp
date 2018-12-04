{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '网站推荐列表')
{{--body内容--}}
@section('body')
    <blockquote class="layui-elem-quote" id="nav_blockquote">
        <div class="layui-inline">
            <button class="layui-btn layui-btn-sm" onclick="add();">点击添加</button>
            <button class="layui-btn layui-btn-sm" onclick="delMore();">批量删除</button>
        </div>
        <div class="layui-inline">
            <form class="layui-form" id="searchForm">
                <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="关键字" style="width: 100px;">
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
    <script type="text/html" id="imgDemo">
        @{{# if(d.icoUrl == ''){var icoUrl = d.url+'/favicon.ico';}else{var icoUrl = d.icoUrl;} }}
        <img style="height:40px;" src="@{{ icoUrl }}"/>
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
    </script>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
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
                url: '{{url("/Link/showList/getData")}}',
                method: 'post',
                where: searchFormData,
                cols:[[
                    {type:'checkbox',fixed:'left'},
                    {type:'numbers',fixed:'left',title:'序号'},
                    {field:'name',title:'名称',edit:'text',sort:true,align:'center'},
                    {field:'url',title:'URL',edit:'text',sort:true,align:'center'},
                    {field:'sort',title:'排序',edit:'text',sort:true,align:'center'},
                    {field:'status',title:'状态',sort:true,align:'center',templet:'#statusTemplet'},
                    {field:'status',title:'首页显示',sort:true,align:'center',templet:'#isHomeTemplet'},
                    {field:'icoUrl',title:'图标',sort:false,align:'center',minWidth:'100',event:'selImg',templet:'#imgDemo'},
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
        //监听状态
        form.on('checkbox(status)', function(data){
            if (data.elem.checked){
                var statusVal = 1;
            }else{
                var statusVal = 0;
            }
            $.post('{{url("/Link/ajaxEdit")}}',{id:data.value,status:statusVal},function(result){
                layer.msg(result.echo);
            },'json').error(function(result){
                if (result.responseJSON.echo){
                    layer.msg(result.responseJSON.echo);
                }else{
                    layer.msg('程序错误!');
                }
            });
        });
        //监听首页显示
        form.on('checkbox(isHome)', function(data){
            if (data.elem.checked){
                var isHomeVal = 1;
            }else{
                var isHomeVal = 0;
            }
            $.post('{{url("/Link/ajaxEdit")}}',{id:data.value,isHome:isHomeVal},function(result){
                layer.msg(result.echo);
            },'json').error(function(result){
                if (result.responseJSON.echo){
                    layer.msg(result.responseJSON.echo);
                }else{
                    layer.msg('程序错误!');
                }
            });
        });
        //监听单元格编辑
        table.on('edit(dataTable)', function(obj){
            //console.log(obj.value); //得到修改后的值
            //console.log(obj.field); //当前编辑的字段名
            //console.log(obj.data); //所在行的所有相关数据  
            var data = {};
            data['id'] = obj.data.id;
            data[obj.field] = obj.value;
            $.post('{{url("/Link/ajaxEdit")}}',data,function(result){
                layer.msg(result.echo);
            },'json').error(function(result){
                if (result.responseJSON.echo){
                    layer.msg(result.responseJSON.echo);
                }else{
                    layer.msg('程序错误!');
                }
            });
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
                    $.get('{{url("/Link/ajaxDel")}}',{id:del_id},function(result){
                        layer.msg(result.echo);
                        if(result.status){
                            obj.del(); //删除对应行（tr）的DOM结构
                            layer.close(index);
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
            }else if(layEvent === 'edit'){
                layer.open({
                    title:data.name,
                    type:2,
                    area:['700px', '420px'],
                    maxmin: true,
                    content: '@php echo url("/Link/edit/'+data.id+'")@endphp',
                    end:function(){
                        $('#searchForm')[0].reset();
                        form.render();
                        getDataTable();
                    }
                });
            }else if(layEvent === 'selImg'){
                return false;
                if(data.icoUrl == ''){
                    var icoUrl = data.url+'/favicon.ico';
                }else{
                    var icoUrl = data.icoUrl;
                }
                layer.open({
                    type: 1,
                    area:'500px',
                    title: false,
                    closeBtn: 0,
                    shadeClose: true,
                    content: '<img style="width:500px;" src="'+icoUrl+'"/>'
                });
            }
        });
        //添加
        function add(){
            layer.open({
                title:'添加',
                type:2,
                area:['700px', '420px'],
                maxmin: true,
                content: '{{url("/Link/add")}}',
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
                $.get('{{url("/Link/ajaxDel")}}',{id:del_id},function(result){
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