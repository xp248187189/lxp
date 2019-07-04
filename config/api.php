<?php

return [
    //百度地图开放平台
    'baidu_ak' => env('BAIDU_AK'),
    'baidu_sk' => env('BAIDU_SK'),
    //聚合数据
    'juhe_key' => env('JUHE_KEY'),
    //腾讯QQ登录
    'qq_app_id' => env('QQ_APP_ID'),
    'qq_app_key' => env('QQ_APP_KEY'),
    'qq_call_back' => env('QQ_CALL_BACK'),
    'qq_scope' => env('QQ_SCOPE'),
    //易源数据
    'showapi_appid' => env('SHOWAPI_APPID'),
    'showapi_sign' => env('SHOWAPI_SIGN'),
    //随机获取图片
    'getImgApi' => [
        ['title'=>'二次元动漫','url'=>'https://api.ixiaowai.cn/api/api.php'],
        ['title'=>'menhera酱','url'=>'https://api.ixiaowai.cn/mcapi/mcapi.php'],
        ['title'=>'风景','url'=>'https://api.ixiaowai.cn/gqapi/gqapi.php']
    ],
    //vaptcha手势验证的vid
    'vaptcha_vid' => env('VAPTCHA_VID')
];