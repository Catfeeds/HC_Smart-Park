<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/11
 * Time: 13:52
 */

namespace app\api\model;


use think\Model;

/**
 * Class ServiceMeetingroomAppoint
 * @package app\api\model
 * 会议室预约模型
 */
class ServiceMeetingroomAppoint extends Model
{
    /**
     * @var array
     * 显示字段
     */
    protected $visible = [
        's_time',
        'e_time'
    ];

    /**
     * @param $s_time
     * @return false|string
     * 获取格式化的开始时间
     */
    public function getSTimeAttr($s_time)
    {
        return \date('Y-m-d H:i:s', $s_time);
    }

    /**
     * @param $e_time
     * @return false|string
     * 获取格式化的结束时间
     */
    public function getETimeAttr($e_time)
    {
        return \date('Y-m-d H:i:s', $e_time);
    }

    /**
     * @param $map
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据条件获取预约列表
     */
    public function getAppointListByCondition($map)
    {
        $list = $this->where($map)->select();
        return $list;
    }
}