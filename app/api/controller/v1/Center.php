<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 11:33
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;
use think\Request;

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
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 更新个人信息
     * 待解决:昵称是否允许重复,修改手机号后,相关信息是否一起修改,比如投诉建议等
     */
    public function save(Request $request)
    {
        $input = $request->post();
        $res = \model('MemberList')
            ->allowField(true)
            ->save($input, ['member_list_id' => $input['user_id']]);
        $user_info = \model('memberList')
            ->where('member_list_id', 'eq', $input['user_id'])
            ->field('member_list_id,member_list_username,member_list_groupid,member_list_headpic,member_list_tel,member_list_addtime,last_login_ip,last_login_time')
            ->find();
        if ($res) {
            return \show('1', '更新成功', $user_info, 200);
        } else {
            return \show(0, '更新失败', '', 201);
        }
    }
}