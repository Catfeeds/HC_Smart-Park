<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 11:33
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;
use think\Db;

/**
 * Class Center
 * @package app\api\controller\v1
 * 个人中心
 */
class Center extends AuthBase
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回个人基本信息
     */
    public function index()
    {
        $user_id = \input('user_id');
        $user_info = \model('MemberList')
            ->where('member_list_id', 'eq', $user_id)
            ->field('member_list_id,member_list_username,member_list_groupid,member_list_headpic,member_list_tel,member_list_addtime,last_login_ip,last_login_time')
            ->find();
        return \show(1, 'OK', $user_info, 200);
    }

    /**
     * @return \think\response\Json
     * 修改用户名
     */
    public function update_username()
    {
        if (\request()->isPost()) {
            $user_id = \input('user_id');
            $new_username = \input('user_name');
            $count_username = Db::name('MemebrList')
                ->where('member_list_username', 'eq', $new_username)
                ->count();
            if ($count_username > 0) {
                return \show('0', '改昵称已存在');
            } else {
                $res = Db::name('MemberList')
                    ->where('member_list_id', 'eq', $user_id)
                    ->setField('member_list_username', $new_username);
                if ($res) {
                    return \show('1', '修改成功');
                } else {
                    return \show('0', '修改失败');
                }
            }
        } else {
            return \show(0, '提交方式不正确');
        }

    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 更新手机号
     */
    public function update_phone()
    {
        if (\request()->isPost()) {
            $user_id = \input('user_id');
            $new_phone = \input('phone');
            $count_phone = Db::name('MemberList')
                ->where('member_list_phone', 'eq', $new_phone)
                ->count();
            if ($count_phone > 0) {
                return \show('0', '手机号已存在');
            } else {
                $res = \checksms($new_phone, 3, \input('verify'));
                if (!$res) {
                    return \show('0', '验证码错误');
                } else {
                    $rst = Db::name('MemberList')
                        ->where('member_list_id', 'eq', $user_id)
                        ->setField('member_list_tel', $new_phone);
                    if ($rst) {
                        \show('1', '修改成功');
                    } else {
                        \show(0, '修改失败');
                    }
                }
            }
        } else {
            return \show(0, '提交方式不正确');
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 设置密码
     * 不管是重置密码,修改密码都是手机号+验证码,不需要验证旧密码
     */
    public function setpwd()
    {
        $user_id = \input('user_id');
        $phone = \input('phone');
        $verify = \input('verify');
        $res = \checksms($phone, 3, $verify);
        if (!$res) {
            return \show(0, '验证码错误');
        } else {
            $salt = random(10);
            $new_pwd = \encrypt_password(\input('password'), $salt);
            $rst = Db::name('MemberList')
                ->where('member_list_id', 'eq', $user_id)
                ->setField(['member_list_pwd' => $new_pwd, 'member_list_salt' => $salt]);
            if ($rst) {
                return \show(1, '修改成功');
            } else {
                return \show(0, '修改失败');
            }
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 绑定企业
     */
    public function bind_enterprise()
    {
        if (!\request()->isPost()) {
            return \show(0, '提交方式不正确');
        } else {
            $user_id = \input('user_id');
            $slqdata['member_list_enterprise'] = \input('enterprise_code');
            $slqdata['member_list_nickname'] = \input('realname');
            $slqdata['member_list_department'] = \input('department');
            if (!$user_id || !$slqdata['member_list_enterprise'] || !$slqdata['member_list_nickname'] || !$slqdata['member_list_department']) {
                return \show(0, '信息不完整');
            } else {
                $enterpriseInfo = \getEnterpriseBasicInfoByCode(\input('enterprise_code'));
                $slqdata['member_list_enterprise'] = $enterpriseInfo['id'];
                $rst = \model('MemberList')->save($slqdata, ['member_list_id' => $user_id]);
                $info = Db::name('MemberList')
                    ->where('member_list_id', 'eq', $user_id)
                    ->field('member_list_id,member_list_enterprise,member_list_nickname,member_list_department')
                    ->find();
                if ($rst) {
                    return \show(1, '绑定成功', $info, 200);
                } else {
                    return \show(0, '绑定失败');
                }
            }
        }
    }
}