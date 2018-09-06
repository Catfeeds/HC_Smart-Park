<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 20:46
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\api\library\Aes;
use app\api\library\exception\ApiException;
use app\api\library\IAuth;
use think\cache\driver\Redis;

/**
 * Class Login
 * @package app\api\controller\v1
 * 登录模块
 */
class Login extends Common
{
    /**
     * @return \think\response\Json
     * 登录操作
     */
    public function save()
    {
        $type = \input('type');     //登录方式
        switch ($type) {
            case 1:
                //todo 手机号+密码登录

                //登录成功执行
                $this->after_login();
                break;
            case 2:
                //todo 手机号+验证码登录

                //登录成功执行
                $this->after_login();
                break;
            default:
                return new ApiException('登录方式不正确','200',0);
        }
    }

    /**
     * @return \think\response\Json
     * 登录成功后token的操作
     */
    function after_login($phone)
    {
        $user_id = \getUserIdByPhone($phone);
        $token = IAuth::setAppLoginToken();
        //token存入redis,并赋值user_id,这样就知道用户的id了.
        $redis = new Redis();
        $redis->set($token, $user_id, \config('token_expires_time'));
        //返回加密后的token
        $token = Aes::encrypt($token);
        return \show('1', 'OK', $token, 200);
    }
}