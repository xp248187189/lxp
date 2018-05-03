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
    var index = layer.load(1);
    //模拟留言回复
    setTimeout(function () {
        layer.close(index);
        var content = data.field.replyContent;
        var html = '<div class="comment-child"><img src="../images/Absolutely.jpg"alt="Absolutely"/><div class="info"><span class="username">模拟回复</span><span>' + content + '</span></div><p class="info"><span class="time">2017-03-18 18:26</span></p></div>';
        $(data.form).find('textarea').val('');
        $(data.form).parent('.replycontainer').before(html).siblings('.comment-parent').children('p').children('a').click();
        layer.msg("回复成功", { icon: 1 });
    }, 500);
    return false;
});
function btnReplyClick(user) {
    $("html,body").animate({scrollTop: $('#gt').offset().top-65}, 1000);
    $('textarea[name="editorContent"]').text('@'+user+'&nbsp;');
    // layedit.build('remarkEditor', {
    //     height: 150,
    //     tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
    // });
    // $('.layui-layedit').find('iframe').contents().find('body').html('').focus().html('@'+user+'&nbsp;');
    $('.layui-layedit').find('iframe').contents().find('body').html('@'+user+'&nbsp;');
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