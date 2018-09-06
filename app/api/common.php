<?php

use app\api\library\Aes;
use think\Db;
use think\cache\driver\Redis;
/**
 * @param $status 业务状态码
 * @param $message 提示信息
 * @param array $data 数据
 * @param int $httpCode http状态码
 * @return \think\response\Json
 * 通用的api数据输出方法
 */
function show($status, $message, $data = [], $httpCode = 200)
{
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
    return json($data, $httpCode);
}


/**
 * @param $phone
 * @return mixed
 * 根据会员手机号获取ID
 */
function getUserIdByPhone($phone)
{
    $user_id = Db::name('MemberList')->where('member_list_tel', 'eq', $phone)->value('member_list_id');
    if ($user_id){
        return $user_id;
    }else{
        return false;
    }
}

/**
 * @param $token
 * @return mixed
 * 根据token获取用户id
 */
function getUserIdByToken($token)
{
    //先解密token
    $token = Aes::decrypt($token);
    //去Redis拿$token的值,也就是登录时存进去的user_id
    $redis = new Redis();
    $user_id = $redis->get($token);
    if ($user_id){
        return $user_id;
    }else{
        return false;
    }
}