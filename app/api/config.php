<?php
//配置文件
return [
    // api调试模式
    'app_debug' => true,
    // 默认输出类型
    'default_return_type' => 'json',
    //api异常处理类
    'exception_handle' => '\app\api\library\ExceptionHandle',
    //默认密码
    'default_password' => '',
    //sign有效期,秒
    'app_sign_time' => '30',
    //token有效期,秒
    'token_expires_time' => '2592000',
    //APP版本信息
    'app_version' => [
        'version' => '1.0.1',
        'publish_time' => '2018-09-20',
        'size' => '15M',
        'content' => '杀了一个程序员祭天,保佑中秋节不宕机',
        'download_url' => 'https://fosduhik;ghsklgjhsdh.com',
        'is_force' => '1',
    ],
    //七牛云的上传地址
    'upload_url' => 'http://up.qiniup.com/putb64/-1/key/',

    //分页配置
    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 10000000000000000,
    ],
];