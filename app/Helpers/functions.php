<?php
/**
 * @param string $name textarea文本域的name
 * @param string $content 默认值
 * @param string $toolbars 工具栏
 */
function showUEditor(string $name,$content='',$toolbars='all'){
    if ($toolbars == 'all') {
        $config = <<<EOP
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
                ]],
            initialFrameWidth:"99%",
            zIndex:1
EOP;
    }else if ($toolbars == 'notFile'){
        $config = <<<EOP
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
                ]],
            initialFrameWidth:"99%",
            zIndex:1
EOP;
    }else if ($toolbars == 'nothing'){
        $config = <<<EOP
            toolbars: [],
            autoHeightEnabled: true,
            autoFloatEnabled: true,
            enableAutoSave: false,
            readonly:true,
            wordCount:false,
            enableContextMenu: false,
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
    $str.= 'var ue_'.$name.' = UE.getEditor("'.$name.'",{'.$config.'});';
    $str.= '</script>';
    //设置为true表示已经加载
    $isLodeScript = true;
    echo $str;
}
/**
 * @param string $UEditorContent 内容
 */
function showUEditorContent($UEditorContent=''){
    //定义一个静态变量为false，表示未加载，
    //用于判断是否是第一次加载，因为配置文件以及编辑器源码文件只能加载一次
    static $isLodeScript = false;
    $idName = str_random();
    $str = '';
    //判断是否加载了配置文件和编辑器源码文件
    if ($isLodeScript === false){
        $str.= '<script type="text/javascript" src="'.asset('UEditor').'/ueditor.parse.js"></script>';
    }
    $str.= '<div id="showUEditorContent_'.$idName.'">';
    $str.= $UEditorContent;
    $str.= '</div>';
    $str.= '<script type="text/javascript">';
    $str.= 'uParse("#showUEditorContent_'.$idName.'",{rootPath:"'.asset('UEditor').'"});';
    $str.= '</script>';
    //这里给 li 标签加上 list-style:initial 属性是因为 layui 自带的css库里面的 li 标签的样式是全局的，这里要把它设置成默认值
    // style="list-style:initial";//将这个属性设置为默认值
    $str.= '<script type="text/javascript">';
    $str.= 'var li_obj = document.getElementById("showUEditorContent_'.$idName.'").getElementsByTagName("li");';
    $str.= 'for (var i = 0; i < li_obj.length; i++) {';
    $str.= 'li_obj[i].setAttribute("style","list-style:initial;");';
    $str.= '}';
    $str.= '</script>';
    //设置为true表示已经加载
    $isLodeScript = true;
    echo $str;
}
/**
 * 根据ip地址获取地理信息
 * @param  string $ip ip地址
 * @return array      地理信息
 */
function getIpLookup($ip = ''){
    if(empty($ip)){
        return false;
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){
        return false;
    }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){
        return false;
    }
    $json = json_decode($jsonMatches[0],true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}
/**
 * 二维数组根据字段进行排序
 * @param array  $array 需要排序的数组
 * @param string $field 排序的字段
 * @param string $sort  排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
 * @return array        排好序的二维数组
 */
function arraySequence($array, $field, $sort = 'SORT_DESC'){
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$field], constant($sort), $array);
    return $array;
}

/**
 * 根据key 给二维数组分组
 * @param array $arr 需要分组的数组
 * @param string $key 分组字段
 * @return array 分好组的数组
 */
function arrayGroupBy(array $arr, string $key){
    $grouped = [];
    foreach ($arr as $value) {
        $grouped[$value[$key]][] = $value;
    }
    if (func_num_args() > 2) {
        $args = func_get_args();
        foreach ($grouped as $key => $value) {
            $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$key] = call_user_func_array('arrayGroupBy', $parms);
        }
    }
    return $grouped;
}

/**
 * 判断多维数据是否存在某个值
 * @param  string $value 要判断的值
 * @param  array $array 多维数组
 * @return boolean
 */
function deep_in_array(string $value,array $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }

        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}