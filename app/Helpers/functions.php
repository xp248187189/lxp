<?php
/**
 * @param string $name textarea文本域的name
 * @param string $content 默认值
 * @param string $toolbars 工具栏
 */
function showUEditor(string $name,$content='',$toolbars='all'){
    if ($toolbars == 'all') {
        $toolbars = <<<EOP
            toolbars: [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
                    'horizontal', 'date', 'time', 'spechars', 'wordimage', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                    'preview', 'searchreplace', 'drafts'
                ]]
EOP;
    }else if ($toolbars == 'notFile'){
        $toolbars = <<<EOP
            toolbars: [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'emotion', 'scrawl', 'map', 'insertframe', 'insertcode', 'pagebreak', 'template', 'background', '|',
                    'horizontal', 'date', 'time', 'spechars', '|',
                    'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                    'preview', 'searchreplace', 'drafts'
                ]]
EOP;
    }
    //定义一个静态变量为false，表示未加载，
    //用于判断是否是第一次加载，因为配置文件以及编辑器源码文件只能加载一次
    static $isLodeScript = false;
    //加载编辑器的容器
    $str = '<script id="'.$name.'" name="'.$name.'" type="text/plain">';
    $str.= $content;
    $str.= '</script>';
    //判断是否加载了配置文件和编辑器源码文件
    if ($isLodeScript === false){
        $str.= '<script type="text/javascript" src="'.asset('UEditor').'/ueditor.config.js"></script>';//配置文件
        $str.= '<script type="text/javascript" src="'.asset('UEditor').'/ueditor.all.js"></script>';//编辑器源码文件
    }
    $str.= '<script type="text/javascript">';
    $str.= 'var ue_'.$name.' = UE.getEditor("'.$name.'",{'.$toolbars.',initialFrameWidth:"99%"});';
    $str.= '</script>';
    //设置为true表示已经加载
    $isLodeScript = true;
    echo $str;
}