<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/27
 * Time: 9:50
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\api\model\ParkMeetingRoom;
use think\Db;

/**
 * Class MeetingRoom
 * @package app\api\controller\v1
 * 会议室控制器
 */
class MeetingRoom extends Common
{
    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 会议室列表
     */
    public function index()
    {
        $model = new ParkMeetingRoom();
        $list = $model->getMeetingRoomList();
        return $list;
    }

    /**
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * 会议室详情
     */
    public function read()
    {
        $id = \input('id');
        $info = ParkMeetingRoom::get($id)->append(['content']);
        if (!empty($info)) {
            return \show(1, 'OK', $info, 200);
        } else {
            return \show(0, '会议室不存在或不可用', '', 201);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 会议室预约申请
     */
    public function save()
    {
        $room_id = \input('meetingroom_id');
        $u_id = \input('user_id');
        $s_time = \strtotime(\input('start_time'));
        $e_time = \strtotime(\input('end_time'));
        if ($room_id && $u_id && $s_time && $e_time) {
            //判断会议室是否可用
            $room = Db::name('ParkMeetingRoom')->where('id', 'eq', $room_id)->find();
            if (empty($room)) {
                return \show('0', '会议室不存在或不可用', '', 201);
            }
            //判断会议室时间和已预订的时间是否冲突
            $time_check = Db::name('ServiceMeetingroomAppoint')
                ->where('meetingroom_id', 'eq', $room_id)
                ->where('s_time|e_time', 'between', [$s_time, $e_time])
//                ->where('status','neq',1)
                ->find();
            if (!empty($time_check)) {
                return \show(0, '时间冲突,请重新选择', '', 201);
            } else {
                $sqldata = [
                    'meetingroom_id' => $room_id,
                    'user_id' => $u_id,
                    's_time' => $s_time,
                    'e_time' => $e_time,
                    'create_time' => \time(),
                ];
                Db::name('ServiceMeetingroomAppoint')->insert($sqldata);
                return \show(1, '预约成功,请等待审核结果', '', 200);
            }
        } else {
            return \show(0, '请求信息不完整', '', 201);
        }
    }
}