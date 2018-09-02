<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 21:13
 */

namespace app\api\library;

use think\Cache;

/**
 * Iauth相关
 * Class IAuth
 */
class IAuth
{

    /**
     * @return string
     * token生成方法
     */
    public static function setAppLoginToken(){
        $token =  \sha1(md5(\uniqid(md5(\microtime(true)),true)));
        return $token;
    }
    /**
     * 设置密码
     * @param string $data
     * @return string
     */
    public static function setPassword($data)
    {
        return md5($data . config('password_pre_halt'));
    }

    /**
     * 生成每次请求的sign
     * @param array $data
     * @return string
     */
    public static function setSign($data = [])
    {
        // 1 按字段排序
        ksort($data);
        // 2拼接字符串数据  &
        $string = http_build_query($data);
        // 3通过aes来加密
        $string = (new Aes())->encrypt($string);
        return $string;
    }

    /**
     * 检查sign是否正常
     * @param array $data
     * @param $data
     * @return boolen
     */
    public static function checkSignPass($data)
    {
        $str = (new Aes())->decrypt($data['sign']);

        if (empty($str)) {
            return false;
        }

        // did=xx&app_type=3
        parse_str($str, $arr);
        if (!is_array($arr) || empty($arr['did'])
            || $arr['did'] != $data['did']
        ) {
            return false;
        }
        if (!config('app_debug')) {
            if ((time() - ceil($arr['time'] / 1000)) > config('app_sign_time')) {
                return false;
            }
            //echo Cache::get($data['sign']);exit;
            // 唯一性判定
            if (Cache::get($data['sign'])) {
                return false;
            }
        }
        return true;
    }
}