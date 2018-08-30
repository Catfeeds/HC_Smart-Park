<?php
//配置文件
return [
    // api调试模式
    'app_debug'              => true,
    // 默认输出类型
    'default_return_type' => 'json',
    //api异常处理类
    'exception_handle' => '\app\api\library\ExceptionHandle',
    //加密salt
    'password_pre_halt'=>'',
    //sign有效期,秒
    'app_sign_time'=>'600'
];