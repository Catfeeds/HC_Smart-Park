<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 21:06
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Db;

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
    public function index()
    {
        $phone = \input('phone');
        $type = \input('type');
        if ($type == 1) {
            //注册模板
            $templateCode = 'SMS_145187285';
            $phone_count = Db::name('MemberList')->where('member_list_tel', 'eq', $phone)->count();
            if ($phone_count > 0) {
                return \show(0, '该手机号已被注册', '', 403);
            }
        } elseif ($type == 2) {
            //登录模板
            $templateCode = 'SMS_145187287';
        } else {
            //其他
            $templateCode = 'SMS_145295356';
        }
        //tp5内置规则怎么都没有用,所以
        //验证手机号
        $rule = '/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|16[6]|(17[0,3,5-8])|(18[0-9])|19[89])\d{8}$/';
        $rst = \preg_match($rule, $phone);
        if (!$rst) {
            return \show(0, '手机号不正确', '',201);
        } else {
            return \sendsms($phone, $type, $templateCode);

        }
    }
}