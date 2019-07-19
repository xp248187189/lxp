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
        $str.= '<script type="text/javascript" src="'.asset('UEditor/ueditor.config.js').'"></script>';//配置文件
        $str.= '<script type="text/javascript" src="'.asset('UEditor/ueditor.all.js').'"></script>';//编辑器源码文件
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
        $str.= '<script type="text/javascript" src="'.asset('UEditor/ueditor.parse.js').'"></script>';
        $str.= '<script src="'.asset('Common/js/jquery-3.3.1.min.js').'"></script>';
    }
    $str.= '<div id="showUEditorContent_'.$idName.'">';
    $str.= $UEditorContent;
    $str.= '</div>';
    $str.= '<script type="text/javascript">';
    $str.= 'var callback = function(){';
    $str.= 'var body_width = document.body.clientWidth;';
    $str.= 'var td_width = body_width-55;';
    $str.= '$(".syntaxhighlighter .code .container").attr("style","width: "+td_width+"px!important;overflow-x: auto!important;overflow-y: hidden!important;")';
    $str.= '};';
    $str.= 'uParse("#showUEditorContent_'.$idName.'",{rootPath:"'.asset('UEditor').'"},callback);';
    $str.= '</script>';
    //这里给 li 标签加上 list-style:initial 属性是因为 layui 自带的css库里面的 li 标签的样式是全局的，这里要把它设置成默认值
    // style="list-style:initial";//将这个属性设置为默认值
    // $str.= '<script type="text/javascript">';
    // $str.= 'var li_obj = document.getElementById("showUEditorContent_'.$idName.'").getElementsByTagName("li");';
    // $str.= 'for (var i = 0; i < li_obj.length; i++) {';
    // $str.= 'li_obj[i].setAttribute("style","list-style:initial;");';
    // $str.= '}';
    // $str.= '</script>';
    //设置为true表示已经加载
    $isLodeScript = true;
    echo $str;
}
/**
 * 根据ip地址获取地理信息
 * @param  string $ip ip地址
 * @return mixed      地理信息
 */
function getIpLookup($ip = ''){
    if(empty($ip) || $ip == '127.0.0.1'){
        return false;
    }
    $url = "https://api.map.baidu.com/location/ip?ip=%s&ak=%s&sn=%s";
    $uri = '/location/ip';
    $ak = config('api.baidu_ak');
    $sk = config('api.baidu_sk');
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
    if (is_object($res) && $res->status === 0){
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
 * @param  array $querystring_arrays 请求串数组
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
 * 自己封装的 cURL 方法
 * @param string    $url    请求网址
 * @param bool      $params 请求参数
 * @param bool      $ispost 是否post请求
 * @param bool      $https  https协议
 * @return bool|mixed
 */
function curl($url, $params = false, $ispost = false, $https = false){
    $httpInfo = array();
    $ch = curl_init();
    //强制使用 HTTP/1.1
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    //在HTTP请求中包含一个"User-Agent: "头的字符串。
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36');
    //在尝试连接时等待的秒数。设置为0，则无限等待。
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    //允许 cURL 函数执行的最长秒数。
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($https) {
        //FALSE 禁止 cURL 验证对等证书（peer's certificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)。
        //译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。
        // 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。
        // 0 为不检查名称。
        // 在生产环境中，这个值应该是 2（默认值）。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    if ($ispost) {
        //TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。
        curl_setopt($ch, CURLOPT_POST, true);
        //这个参数可以是 urlencoded 后的字符串，类似'para1=val1&para2=val2&...'，也可以使用一个以字段名为键值，字段数据为值的数组。
        //如果value是一个数组，Content-Type头将会被设置成multipart/form-data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        //需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候。
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
    //最后一个收到的HTTP代码
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //获取一个cURL连接资源句柄的信息(包括 最后一个收到的HTTP代码)
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    //这里就直接返回接收到的数据，不反悔http信息了
    return $response;
}

/**
 * @param  string   $paramDate 日期 格式为2018-05-02 10:30:05
 * @return string
 */
function timeAgo(string $paramDate){
    //设置中国时区
    // date_default_timezone_set('PRC');
    //前天的开始时间 0点0分0秒
    $beforeYesterdayStartTime = mktime(0,0,0,date('m'),date('d')-2,date('Y'));
    //前天的结束时间 23点59分59秒
    $beforeYesterdayEndTime = mktime(0,0,0,date('m'),date('d')-1,date('Y'))-1;
    //昨天的开始时间 0点0分0秒
    $yesterdayStartTime = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
    //昨天的结束时间 23点59分59秒
    $yesterdayEndTime = mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
    //今天的开始时间 0点0分0秒
    $todayStartTime = mktime(0,0,0,date('m'),date('d'),date('Y'));
    //今天的结束时间 23点59分59秒
    $todayEndTime = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
    //目前的时间
    $nowTime = time();
    // $nowTime = 1529661050;
    //今天的开始时间到目前时间的秒数
    $todayStartTimeToNowTime = $nowTime - $todayStartTime;
    //参数的时间戳
    $paramTime = strtotime($paramDate);
    //判断是否是未来时间(未来时间直接返回)
    if ($nowTime < $paramTime) {
        return $paramDate;
    }
    //时间差
    $timeDifference = $nowTime - $paramTime;
    //判断参数时间是否是在今天
    if ($paramTime >= $todayStartTime) {
        if ($timeDifference <= 10) {
            return '刚刚';
        }else if($timeDifference >10 && $timeDifference < 60){
            return $timeDifference.'秒前';
        }else if($timeDifference >=60 && $timeDifference < 3600){
            return intval(($timeDifference/60)).'分钟前';
        }else if($timeDifference >=3600 && $timeDifference <= $todayStartTimeToNowTime){
            return intval(($timeDifference/3600)).'小时前';
        }else{
            return $paramDate;
        }
    }
    if ($paramTime >= $yesterdayStartTime && $paramTime <= $yesterdayEndTime) {
        return '昨天';
    }
    if ($paramTime >= $beforeYesterdayStartTime && $paramTime <= $beforeYesterdayEndTime) {
        return '前天';
    }
    return $paramDate;
}

/**
 * 对数据进行编码转换
 * @param string    $data       需要转换的字符串
 * @param string    $output     转换后的编码
 * @return string               转换后的字符串
 */
function array_iconv(string $data,$output = 'utf-8') {
    $encode_arr = array('UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP');
    $encoded = mb_detect_encoding($data, $encode_arr);//自动判断编码
    return mb_convert_encoding($data, $output, $encoded);
}

/**
 * 随机获取存在本地的bing每日图片
 * @return mixed
 */
function randGetBingEverydayImg(){
    static $arr;
    $arr = \Illuminate\Support\Facades\Storage::disk('bingEverydayImg')->allFiles();
    return $arr[array_rand($arr,1)];
}

/**
 * 随机获取bing网站的每日图片
 * @return mixed
 */
function randGetBingEverydayImgForOnline(int $num = 1) {
    if ($num > 15 || $num < 1){
        return false;
    }
    //缓存24小时,避免一直请求外站 也就是 1440分钟
    $imgs = Illuminate\Support\Facades\Cache::remember('bingEverydayImgForOnline', 1440, function () {
        $img = [];
        for ($i = 0; $i <= 7; $i++) {
            $url = 'https://cn.bing.com/HPImageArchive.aspx?format=js&idx=' . $i . '&n=8';
            $res = curl($url, false, false, true);
            $res = json_decode($res, true);
            foreach ($res['images'] as $key => $value) {
                $str = substr($value['url'], 0, 4);
                if ($str == 'http'){
                    $img[] = $value['url'];
                }else{
                    $img[] = 'https://cn.bing.com' . $value['url'];
                }
            }
        }
        //去重后就是最近15天的图片了
        $img = array_unique($img);
        //重新排列键值
        $img = array_values($img);
        return $img;
    });
    //随机返回一张
    if ($num == 1){
        return $imgs[array_rand($imgs, 1)];
    }else{
        //随机返回指定数量
        $imgList = [];
        $keyArr = array_rand($imgs, $num);
        foreach ($keyArr as $key => $value){
            $imgList[] = $imgs[$value];
        }
        return $imgList;
    }
}

/**
 * 根据qq号获取qq名称
 * @param string $qq
 * @return mixed
 */
function getQQName(string $qq){
    $param = [
        'uins' => $qq
    ];
    $url = 'http://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg';
    $res = curl($url,$param);
    $res = array_iconv($res);
    $res = str_replace("\n", '', $res);
    preg_match('/\{.*\}/',$res,$matches);
    $qqInfo = json_decode($matches[0],true);
    if (empty($qqInfo) || isset($qqInfo['error'])){
        return isset($qqInfo['error']['msg']) ? $qqInfo['error']['msg'] : false;
    }
    $qqInfo = array_values($qqInfo);
    $qqName = $qqInfo[0][6];
    return $qqName;
}

/**
 * 根据qq号获取qq头像url
 * @param string $qq
 * @return string
 */
function getQQHeadPortrait(string $qq){
    return 'https://q1.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
}