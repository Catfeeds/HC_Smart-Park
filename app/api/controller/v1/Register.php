<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 20:47
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

/**
 * Class Register
 * @package app\api\controller\v1
 * 注册模块
 */
class Register extends Common
{
    /**
     * @return \think\response\Json
     * 注册
     */
    public function save()
    {

        if (!\request()->isPost()) {
            return \show(0, '提交方式不正确', 403);
        } else {


            //首先验证手机验证码
            $account = \input('phone');
            $type = 1;
            $verify = \input('verify');
            $smsres = \checksms($account, $type, $verify);
            if (!$smsres) {
                return \show(0, '手机验证码错误');
            } else {
                //todo 注册逻辑
            }
        }
    }
}