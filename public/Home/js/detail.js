//prettyPrint();
//评论和留言的编辑器
var editIndex = layedit.build('remarkEditor', {
    height: 150,
    tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
});
//评论和留言的编辑器的验证
form.verify({
    content: function (value) {
        value = $.trim(layedit.getContent(editIndex));
        if (value == "") return "自少得有一个字吧";
        layedit.sync(editIndex);
    }
});
//监听评论提交
form.on('submit(formRemark)', function (data) {
    var commentForm = getFormData("commentForm");
    $.post('/ArticleComment',commentForm,function(result){
        window.location.reload();
    },'json').error(function(){layer.msg('程序错误!');});
    return false;
});