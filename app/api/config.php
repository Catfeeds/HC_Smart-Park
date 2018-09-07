<?php
//配置文件
return [
    // api调试模式
    'app_debug' => true,
    // 默认输出类型
    'default_return_type' => 'json',
    //api异常处理类
    'exception_handle' => '\app\api\library\ExceptionHandle',
    //加密salt
    'password_pre_halt' => '',
    //sign有效期,秒
    'app_sign_time' => '30',
    //token有效期,秒
    'token_expires_time' => '2592000',
    //APP版本号
    'version' => '1.0',

    // redis缓存
    'redis' => [
        // 驱动方式
        'type' => 'redis',
        // 服务器地址
        'host' => '127.0.0.1',
    ],
    //七牛云的上传地址
    'upload_url' => 'http://up.qiniup.com/putb64/-1/key/',
];