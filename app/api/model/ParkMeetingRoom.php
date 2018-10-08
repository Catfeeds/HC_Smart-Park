<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/27
 * Time: 9:52
 */

namespace app\api\model;


use think\Model;

/**
 * Class ParkMeetingRoom
 * @package app\api\model
 * 会议室模型
 */
class ParkMeetingRoom extends Model
{
    /**
     * @var array
     * 隐藏字段
     */
    protected $hidden = [
        'listorder',
        'status',
        'create_time',
        'room_pic_content',
        'content'
    ];

    /**
     * @param $equipment
     * @return mixed
     * 返回前端方便使用的设备信息
     */
    public function getEquipmentAttr($equipment)
    {
        return \unserialize($equipment);
    }

    /**
     * @param $room_img
     * @return string
     * 返回拼接好的会议室封面
     */
    public function getRoomImgAttr($room_img)
    {
        if (!empty($room_img)) {
            return \request()->domain() . $room_img;
        }
    }

    /**
     * @param $room_pic_allurl
     * @return array|string
     * 返回拼接好的会议室多图
     */
    public function getRoomPicAllurlAttr($room_pic_allurl)
    {
        if (!empty($room_pic_allurl)) {
            $arr = \explode(',', $room_pic_allurl);
            foreach ($arr as &$v) {
                if (!empty($v)) {
                    $v = \request()->domain() . $v;
                }
            }
            return array_filter($arr);
        } else {
            return '';
        }

    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回会议室列表
     */
    public function getMeetingRoomList()
    {
        $map['status'] = 1;
        $list = $this->where($map)->select();
        return $list;
    }
}