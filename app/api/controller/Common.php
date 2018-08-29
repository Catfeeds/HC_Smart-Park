<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:28
 */

namespace app\api\controller;


use app\api\library\Aes;
use think\Controller;

/**
 * Class Common
 * @package app\api\controller
 * api模块公共控制器
 */
class Common extends Controller
{
    /**
     *初始化方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
        $this->doAes();
    }

    /**
     *检查每次app请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //获取header信息
        $headers = \request()->header();
//        \halt($headers);
    }

    //sign 加密-->前端

    //sign 解密-->后端

    public function doAes()
    {
        $str = 'xpwsgg';
        echo (new Aes())->encrypt($str);
        echo (new Aes())->decrypt('H+7D/uKxG+C77iGiteVVnw==');
    }
}