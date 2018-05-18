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
//Hash地址的定位
var layid = location.hash.replace(/^#tabIndex=/, '');
if (layid == "") {
    element.tabChange('tabAbout', 1);
}
element.tabChange('tabAbout', layid);
element.on('tab(tabAbout)', function (elem) {
    location.hash = 'tabIndex=' + $(this).attr('lay-id');
});
//监听留言提交
form.on('submit(formLeaveMessage)', function (data) {
    var commentForm = getFormData("commentForm");
    $.post('/UserComment',commentForm,function(result){
        window.location.reload();
    },'json').error(function(){layer.msg('程序错误!');});
    return false;
});
//监听留言回复提交
form.on('submit(formReply)', function (data) {
    var content = $.trim(data.field.replyContent);
    var pid = data.field.pid;
    if(content == ''){
        layer.msg('自少得有一个字吧',{icon: 5,anim: 6});
        return false;
    }
    $.post('/UserComment',{editorContent:content,pid:pid},function(result){
        window.location.reload();
    },'json').error(function(){layer.msg('程序错误!');});
    return false;
});
function btnReplyClick(elem) {
    $(elem).parent('p').parent('.comment-parent').siblings('.replycontainer').toggleClass('layui-hide');
    if ($(elem).text() == '回复') {
        $(elem).text('收起')
    } else {
        $(elem).text('回复')
    }
}
systemTime();
function systemTime() {
    //获取系统时间。
    var dateTime = new Date();
    var year = dateTime.getFullYear();
    var month = dateTime.getMonth() + 1;
    var day = dateTime.getDate();
    var hh = dateTime.getHours();
    var mm = dateTime.getMinutes();
    var ss = dateTime.getSeconds();
    //分秒时间是一位数字，在数字前补0。
    mm = extra(mm);
    ss = extra(ss);
    //将时间显示到ID为time的位置，时间格式形如：19:18:02
    document.getElementById("time").innerHTML = year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
    //每隔1000ms执行方法systemTime()。
    setTimeout("systemTime()", 1000);
}
//补位函数。
function extra(x) {
    //如果传入数字小于10，数字前补一位0。
    if (x < 10) {
        return "0" + x;
    }
    else {
        return x;
    }
}