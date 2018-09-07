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
use think\Db;

/**
 * Class Login
 * @package app\api\controller\v1
 * 登录模块
 */
class Login extends Common
{

    /**
     * @return ApiException|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 登录操作
     */
    public function save()
    {
        $db = Db::name('MemberList');
        $type = \input('type');     //登录方式
        $phone = \input('phone');
        //如果手机号不存在则说明没有注册
        $count_phone = $db->where('member_list_tel', 'eq', $phone)->count();
        if ($count_phone < 1){
            return new ApiException('该手机号尚未注册');
        }else{
            $user_info = $db->where('member_list_tel', 'eq', $phone)->field('member_list_id,member_list_salt,member_list_pwd')->find();
        }
        switch ($type) {
            case 1:
                //手机号+密码登录
                $password = \input('password');
                $salt = $user_info['member_list_salt'];
                $pwd = \encrypt_password($password, $salt);
                if ($pwd == $user_info['member_list_pwd']) {
                    //登录成功执行
                    return $this->after_login($user_info['member_list_id']);
                } else {
                    return new ApiException('登录失败');
                }
                break;
            case 2:
                //手机号+验证码登录
                $verify = \input('verify');
                $verify_rst = \checksms($phone, 2, $verify);
                if (!$verify_rst) {
                    return new ApiException('验证码不正确');
                } else {
                    //登录成功执行
                    return $this->after_login($user_info['member_list_id']);
                }
                //登录成功执行
                return $this->after_login();
                break;
            default:
                return new ApiException('登录方式不正确', '200', 0);
        }
    }


    /**
     * @param $user_id
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 登录成功之后的操作
     */
    function after_login($user_id)
    {
        $db = Db::name('MemberList');
        //更新登录信息
        $updata = [
            'last_login_time' => \time(),
            'last_login_ip' => \request()->ip(),
        ];
        $db->where('member_list_id', $user_id)->setField($updata);
        $token = IAuth::setAppLoginToken();
        //token存入redis,并赋值user_id,这样就知道用户的id了.
        $redis = new Redis();
        $redis->set($token, $user_id, \config('token_expires_time'));
        //返回加密后的token
        $token = Aes::encrypt($token);
        $user_info = $db
            ->where('member_list_id', 'eq', $user_id)
            ->field('member_list_id,member_list_username,member_list_groupid,member_list_tel')
            ->find();
        $user_info['token'] = $token;
        return \show('1', 'OK', $user_info, 200);
    }
}