<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:28
 */

namespace app\api\controller;


use app\api\library\Aes;
use app\api\library\IAuth;
use app\api\library\Time;
use think\Controller;

/**
 * Class Common
 * @package app\api\controller
 * api模块公共控制器
 */
class Common extends Controller
{
    /**
     * @var string
     * 数据头信息
     */
    public $headers = '';

    /**
     *初始化方法
     */
    public function _initialize()
    {
        //$this->checkRequestAuth();
        $this->doAes();
    }

    /**
     *检查每次app请求的数据是否合法
     */
    public function checkRequestAuth()
    {
        //获取header信息
        $headers = \request()->header();

        //sign参数校验
        if (empty($headers['sign'])) {
            $this->error('sign错误', 401);
        } elseif (!IAuth::checkSignPass($headers)) {
            $this->error('授权不合法', 401);
        } else {
            $this->headers = $headers;
        }
    }


    //sign 加密-->前端,解密-->后端

    /**
     * @return bool
     * 加密示例
     */
    public function doAes()
    {
        $str = 'dddddddddddddddddddd';
         echo (new Aes())->encrypt($str);exit;
    }
}