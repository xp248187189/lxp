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
    $url = "https://api.map.baidu.com/location/ip?ip=%s&ak=%s&sn=%s";
    $uri = '/location/ip';
    $ak = config('baiduApi.baidu_ak');
    $sk = config('baiduApi.baidu_sk');
    $querystring_arrays = array(
        'ip' => $ip,
        'ak' => $ak,
    );
    //调用sn计算函数
    $sn = caculateAKSN($ak, $sk, $uri, $querystring_arrays);
    //完整请求的url，请求参数中有中文、特殊字符等需要进行urlencode，确保请求串与sn对应
    $target = sprintf($url, $ip, $ak, $sn);
    //发送请求 ($res 是 stdClass 对象)
    $res = json_decode(curl($target,false,false,true));
    if ($res->status === 0){
        return $res;
    }
    return false;
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

/**
 * 百度地图开放平台获取 sn
 * @param  string $ak                 应用ak
 * @param  string $sk                 应用sk
 * @param  string $uri                get请求uri前缀
 * @param  string $querystring_arrays 请求串数组
 * @param  string $method             请求类型
 * @return string                     sn
 */
function caculateAKSN($ak, $sk, $uri, $querystring_arrays, $method = 'GET'){
    if ($method === 'POST'){
        ksort($querystring_arrays);
    }
    $querystring = http_build_query($querystring_arrays);
    return md5(urlencode($uri.'?'.$querystring.$sk));
}

/**
 * @param $url 请求网址
 * @param bool $params 请求参数
 * @param bool $ispost 是否post请求
 * @param bool $https https协议
 * @return bool|mixed
 */
function curl($url, $params = false, $ispost = false, $https = false){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
    }
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }

    $response = curl_exec($ch);

    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
}