<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 21:28
 */

namespace app\api\controller\v1;


use think\Controller;
/**
 * Class Time
 * @package app\api\controller
 * App获取服务器时间戳
 */
class Time extends Controller
{
    /**
     * @return array
     * 返回时间戳
     */
    public function index(){
        return \show('200', 'OK',\time());
    }
}