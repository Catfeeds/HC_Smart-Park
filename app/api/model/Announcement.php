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
    protected function getAddTimeAttr($addtime){
        return date('Y-m-d', $addtime);
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
            ->field('addtime')
            ->limit('5')
            ->select();
    }
}