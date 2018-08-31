<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 21:14
 */

namespace app\api\library;


/**
 * 时间
 * Class IAuth
 */
class Time
{

    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp()
    {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }
}