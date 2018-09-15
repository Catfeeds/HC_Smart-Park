<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/10
 * Time: 10:58
 */

namespace app\api\model;


use think\Db;
use think\Model;

/**
 * Class MemberList
 * @package app\api\model
 */
class MemberList extends Model
{
    /**
     * @param $member_list_groupid
     * @return mixed
     * 成员组名称读取器
     */
    public function getMemberListGroupidAttr($member_list_groupid)
    {
        return Db::name('MemberGroup')
            ->where('member_group_id', 'eq', $member_list_groupid)
            ->value('member_group_name');
    }

    /**
     * @param $member_list_addtime
     * @return false|string
     * 注册时间读取器
     */
    public function getMemberListAddTimeAttr($member_list_addtime)
    {
        return date('Y-m-d H:i:s', $member_list_addtime);
    }

    /**
     * @param $last_login_time
     * @return false|string
     * 最后登录时间读取器
     */
    public function getlastLoginTimeAttr($last_login_time)
    {
        return date('Y-m-d H:i:s', $last_login_time);
    }
}