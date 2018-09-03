<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 21:06
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

/**
 * Class Sms
 * @package app\api\controller\v1
 * 短信验证码
 */
class Sms extends Common
{
    /**
     *发送验证码
     */
    public function save()
    {
        if (\request()->isPost()) {
            $phone = \input('phone');
            $type = 1;

            //tp5内置规则怎么都没有用,所以
            //验证手机号
            $rule = '/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|16[6]|(17[0,3,5-8])|(18[0-9])|19[89])\d{8}$/';
            $rst = \preg_match($rule, $phone);
            if (!$rst) {
                return \show(0, '手机号不正确', 404);
            } else {
                return \sendsms($phone, $type);
            }
        } else {
            return \show(0, '提交方式不正确', 403);
        }
    }
}