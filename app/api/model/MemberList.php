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
use think\Request;

/**
 * Class MemberList
 * @package app\api\model
 */
class MemberList extends Model
{
    /**
     * @var array
     * 设置显示字段
     */
    protected $visible = [
        'member_list_id',
        'member_list_username',
        'member_list_groupid',
        'member_list_headpic',
        'member_list_tel',
        'member_list_enterprise'
    ];

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
     * @param $member_list_enterprise
     * @return mixed
     * 返回企业名称
     */
    public function getMemberListEnterpriseAttr($member_list_enterprise)
    {
        return Db::name('EnterpriseList')
            ->where('id', 'eq', $member_list_enterprise)
            ->value('enterprise_list_name');
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

    /**
     * @param $member_list_headpic
     * @return string
     * 返回拼接好的头像url
     */
    public function getMemberListHeadpicAttr($member_list_headpic)
    {
        $reqeust = Request::instance();
        if (!empty($member_list_headpic)) {
            return $headpic_url = $reqeust->domain() . '/data/upload/avatar/' . $member_list_headpic;
        } else {
            return '';
        }
    }

    /**
     * @param $user_id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据用id获取基本信息
     */
    public function getMemberInfoById($user_id)
    {
        return $this->where('member_list_id', 'eq', $user_id)
            ->field('member_list_id,member_list_username,member_list_headpic,member_list_groupid,member_list_tel,member_list_enterprise,member_list_addtime,last_login_ip,last_login_time')
            ->find();
    }
}