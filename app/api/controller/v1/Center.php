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
        $user_info = \model('memberList')
            ->where('member_list_id', 'eq', $user_id)
            ->field('member_list_id,member_list_username,member_list_groupid,member_list_headpic,member_list_tel,member_list_addtime,last_login_ip,last_login_time')
            ->find();
        return \show(1, 'OK', $user_info, 200);
    }
}