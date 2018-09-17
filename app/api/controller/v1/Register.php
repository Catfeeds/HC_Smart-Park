<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 20:47
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\api\library\Aes;
use app\api\library\IAuth;
use think\cache\driver\Redis;
use think\Db;

/**
 * Class Register
 * @package app\api\controller\v1
 * 注册模块
 */
class Register extends Common
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 注册
     */
    public function save()
    {

        if (!\request()->isPost()) {
            return \show(0, '提交方式不正确', 403);
        } else {
            if (!\input('phone') || !\input('verify') || !\input('password'))
                return \show('0', '信息不完整', '', 200);
            //首先验证手机验证码
            $account = \input('phone');
            $phone_count = Db::name('MemberList')->where('member_list_tel', 'eq', $account)->count();
            if ($phone_count > 0) {
                return \show(10001, '手机号已存在');
            }

            $type = 1;  //1为注册
            $verify = \input('verify');
            $smsres = \checksms($account, $type, $verify);
            if (!$smsres) {
                return \show(10002, '手机验证码错误');
            } else {
                $member_list_salt = random(10);
                $sqldata = [
                    'member_list_username' => '会员' . \input('phone'),
                    'member_list_pwd' => \encrypt_password(\input('password', \config('default_password')), $member_list_salt),
                    'member_list_salt' => $member_list_salt,
                    'member_list_tel' => \input('phone'),
                    'member_list_groupid' => '1',       //分配一个会员组
                    'member_list_addtime' => \time(),
                ];

                $user_id = Db::name('MemberList')->insertGetId($sqldata);

                if ($user_id !== false) {
                    //注册成功之后直接登录
                    return $this->after_login($user_id);
                } else {
                    return \show(10003, '注册失败', '', 200);
                }


            }
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
        $user_info = \model('MemberList')->getMemberInfoById($user_id);
        $user_info['token'] = $token;
        return \show('1', '注册成功', $user_info, 200);
    }
}