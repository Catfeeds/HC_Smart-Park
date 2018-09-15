<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 23:09
 */

namespace app\api\model;


use think\Model;

/**
 * Class Announcement
 * @package app\api\model
 * 公告模型
 */
class Announcement extends Model
{

    /**
     * @param $addtime
     * @return false|string
     * 时间读取器
     */
    public function getAddTimeAttr($addtime)
    {
        return date('Y-m-d H:i:s', $addtime);
    }

    /**
     * @param $publisher_id
     * @return mixed
     * 发布人姓名读取器
     */
    public function getPublisherIdAttr($publisher_id)
    {
        return \getAdminUserNameById($publisher_id);
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * app首页公告列表
     */
    public function getIndexAnnouncementList()
    {
        return $this
            ->limit('5')
            ->select();
    }
}