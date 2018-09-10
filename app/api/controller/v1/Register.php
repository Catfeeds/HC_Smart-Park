<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 20:47
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
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
            $type = 1;
            $verify = \input('verify');
            $smsres = \checksms($account, $type, $verify);
            if (!$smsres) {
                return \show(0, '手机验证码错误');
            } else {
                $member_list_salt = random(10);
                $sqldata = [
                    'member_list_username' => '会员' . \input('phone'),
                    'member_list_password' => \encrypt_password(\input('password'), $member_list_salt),
                    'member_list_salt' => $member_list_salt,
                    'member_list_tel' => \input('phone'),
                    'member_list_groupid' => '1',       //分配一个会员组
                    'member_list_addtime' => \time(),
                ];

                $user_id = Db::name('MemberList')->insertGetId($sqldata);

                if ($user_id !== false) {
                    //注册完成把用户信息返回给app
                    $user_info = Db::name('MemberList')->where('member_list_id', 'eq', $user_id)->find();
                    return \show(1, '注册成功', $user_info, 200);
                } else {
                    return \show(0, '注册失败', '', 200);
                }


            }
        }
    }
}