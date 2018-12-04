{{--继承模板--}}
@extends('Admin.Public.public')
{{--设置title--}}
@section('title', '角色添加')
{{--style样式--}}
@section('style')
    <style type="text/css">
        .layui-form-item{
            margin-bottom: 0;
        }
        /**
         * 使图标与多选框对其
         */
        #auth_div .layui-form-checkbox{
            vertical-align: bottom !important;
        }
        .div_1{
            margin: 0px 0px 0px 10px;
            display: inline-table;
            width: 300px;
        }
        .div_2{
            margin: 0px 0px 0px 30px;
        }
        .div_3{
            margin: 0px 0px 0px 50px;
        }
    </style>
@endsection
{{--body内容--}}
@section('body')
    <form class="layui-form" action="" id="editForm">
        <input type="hidden" name="id" value="{{$roleInfo->id}}" />
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input" value="{{$roleInfo->name}}">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">排序</label>
                <div class="layui-input-inline">
                    <input type="text" name="sort" lay-verify="number" autocomplete="off" class="layui-input" value="{{$roleInfo->sort}}">
                </div>
            </div>
        </div>
        <div class="layui-form-item" id="auth_div">
            <label class="layui-form-label">权限</label>
            <div class="layui-input-block" style="height:300px;overflow:auto;">
                <?php
                $auth_ids_arr = explode(',',$roleInfo['auth_ids']);
                foreach ($one_authList as $one_value) {
                    echo '<div class="div_1"><i class="fa fa-fw '.(empty($one_value['icon'])?'fa-search':$one_value['icon']).'"></i><input type="checkbox" name="auth_ids[]" value="'.$one_value['id'].'" '.(in_array($one_value['id'],$auth_ids_arr)?'checked':'').' lay-filter="checkbox" lay-skin="primary" title="'.$one_value['name'].'"/>';
                    foreach ($two_authList as $two_value) {
                        if ($two_value['pid']==$one_value['id']) {
                            echo '<div class="div_2"><i class="fa fa-fw '.(empty($two_value['icon'])?'fa-search':$two_value['icon']).'"></i><input type="checkbox" name="auth_ids[]" value="'.$two_value['id'].'" '.(in_array($two_value['id'],$auth_ids_arr)?'checked':'').' lay-filter="checkbox" lay-skin="primary" title="'.$two_value['name'].'"/>';
                            foreach ($three_authList as $three_value) {
                                if ($three_value['pid']==$two_value['id']) {
                                    echo '<div class="div_3"><input type="checkbox" name="auth_ids[]" value="'.$three_value['id'].'" '.(in_array($three_value['id'],$auth_ids_arr)?'checked':'').' lay-filter="checkbox" lay-skin="primary" title="'.$three_value['name'].'"/></div>';
                                }
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <br/>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection
{{--js内容--}}
@section('script')
    <script type="text/javascript">
        /**
         * 点击图标显示与用隐藏
         */
        $('.div_1 > i').on('click',function(){
            var div_2 = $(this).parent('div').find('.div_2');
            if (div_2.is(":hidden")) {
                div_2.show();
            }else{
                div_2.hide();
            }
        });
        $('.div_2 > i').on('click',function(){
            var div_3 = $(this).parent('div').find('.div_3');
            if (div_3.is(":hidden")) {
                div_3.show();
            }else{
                div_3.hide();
            }
        });
        /**
         * 父级选中，子集选中
         */
        form.on('checkbox(checkbox)', function(data){
            var div = $(data.elem).parent('div');//当前div
            if (data.elem.checked) {
                //当前选中，底下所有都选中
                div.find('input[type="checkbox"]').prop("checked", true);
                //如果点击的是div_3
                if (div.attr('class')=='div_3') {
                    var div_2 = div.parent('.div_2');//div_2
                    var div_1 = div_2.parent('.div_1')//div_1
                    div_2.children('input[type="checkbox"]').prop("checked", true);//div_2选中
                    div_1.children('input[type="checkbox"]').prop("checked", true);//div_1选中
                };
                //如果点击的是div_2
                if (div.attr('class')=='div_2') {
                    var div_1 = div.parent('.div_1');//div_1
                    div_1.children('input[type="checkbox"]').prop("checked", true);//div_1选中
                };
            }else{
                //当前未选中，底下所有都不选中
                div.find('input[type="checkbox"]').prop("checked", false);
                //如果点击的是div_3
                if (div.attr('class')=='div_3') {
                    var div_2 = div.parent('.div_2');//div_2
                    var div_1 = div_2.parent('.div_1')//div_1
                    /*这里注释掉是因为我可以选择只要列表权限，不要里面的操作权限*/
                    // var div_3_is_all_checked = false;//判断div_3是否全部选中,默认false全部未选中
                    // div_2.children('.div_3').find('input[type="checkbox"]').each(function(i,v){
                    //     if ($(v).prop('checked')==true) {
                    //         div_3_is_all_checked = true;
                    //     };
                    // });
                    // if (div_3_is_all_checked==false) {
                    //     div_2.children('input[type="checkbox"]').prop("checked", false);//div_2不选中
                    // };
                    var div_2_is_all_checked = false;//判断div_2是否全部选中,默认false全部未选中
                    div_1.children('.div_2').find('input[type="checkbox"]').each(function(i,v){
                        if ($(v).prop('checked')==true) {
                            div_2_is_all_checked = true;
                        };
                    });
                    if (div_2_is_all_checked==false) {
                        div_1.children('input[type="checkbox"]').prop("checked", false);//div_1不选中
                    };
                };
                //如果点击的是div_2
                if (div.attr('class')=='div_2') {
                    var div_1 = div.parent('.div_1');//div_1
                    var div_2_is_all_checked = false;//判断div_2是否全部选中,默认false全部未选中
                    div_1.children('.div_2').find('input[type="checkbox"]').each(function(i,v){
                        if ($(v).prop('checked')==true) {
                            div_2_is_all_checked = true;
                        };
                    });
                    if (div_2_is_all_checked==false) {
                        div_1.children('input[type="checkbox"]').prop("checked", false);//div_1不选中
                    };
                };
            }
            form.render();
        });
        form.on('submit(submit)', function(data){
            var editForm = getFormData("editForm");
            $.ajax({
                url:"{{url('/Role/ajaxEdit')}}",
                type:'post',
                data:editForm,
                dataType:'json',
                success:function(result){
                    layer.msg(result.echo);
                },
                error:function(result){
                    if (result.responseJSON.echo){
                        layer.msg(result.responseJSON.echo);
                    }else{
                        layer.msg('程序错误!');
                    }
                }
            });
            return false;
        });
    </script>
@endsection