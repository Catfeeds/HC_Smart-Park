<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/18
 * Time: 10:57
 */

namespace app\api\controller\charts;


use app\api\model\ParkRoom;
use app\common\controller\Common;
use think\Db;

/**
 * Class Index
 * @package app\api\controller\charts
 * 首页图表接口
 */
class Index extends Common
{
    /**
     * @return mixed
     * 首页房源饼状图数据
     */
    public function room_status()
    {
        $model = new ParkRoom();
        $status0 = $model->where('status', 0)->count();
        $data[0] = ['value' => $status0, 'name' => '未租'];

        $status1 = $model->where('status', 1)->count();
        $data[1] = ['value' => $status1, 'name' => '已租'];

        $status2 = $model->where('status', 2)->count();
        $data[2] = ['value' => $status2, 'name' => '已售'];

        $status3 = $model->where('status', 3)->count();
        $data[3] = ['value' => $status3, 'name' => '已定'];

        $status4 = $model->where('status', 4)->count();
        $data[4] = ['value' => $status4, 'name' => '自留'];
        return $data;
    }


    /**
     * @return array
     * 每月出租房源趋势图
     */
    public function room_month_status()
    {

        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('ParkRoom')
                ->where('entry_time', 'between time', [$m_s, $m_e])
                ->where('status','eq',1)
                ->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     *每月企业入驻数据
     */
    public function enterprise_entry_month()
    {
        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('EnterpriseList')->where('enterprise_list_addtime', 'between time', [$m_s, $m_e])->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     * 每个月注册用户数量
     */
    public function user_month()
    {
        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('MemberList')->where('member_list_addtime', 'between time', [$m_s, $m_e])->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     * 海创二七大楼每层入驻情况(4~23层)
     */
    public function one_floor_entry()
    {
        for ($i = 5; $i < 24; $i++) {
            $data[] = Db::name('ParkRoom')
                ->where('phase', 'eq', 2)//默认为海创二期大楼
                ->where('floor', 'eq', $i)
                ->where('status', 'eq', 1)
                ->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 二期大楼每层的入驻情况
     */
    public function build_floor()
    {
        if (\request()->isPost()) {
            $floor = \input('floor', 1);
            switch ($floor) {
                case ($floor == 1):
                    $data = [
                        'title' => '1F',
                        'content' => '人才市场'
                    ];
                    return \show(1, 'OK', $data, 200);
                    break;
                case ($floor == 2):
                    $data = [
                        'title' => '2F',
                        'content' => '人才中心'
                    ];
                    return \show(1, 'OK', $data, 200);
                    break;
                case ($floor == 3):
                    $data = [
                        'title' => '3F',
                        'content' => '会议室+健身房'
                    ];
                    return \show(1, 'OK', $data, 200);
                    break;
                case($floor == 4):
                    $data = [
                        'title' => '4F',
                        'content' => '众创中心'
                    ];
                    return \show(1, 'OK', $data, 200);
                    break;
                default:
                    $model = new \app\admin\model\ParkRoom();
                    $floor_info = $model
                        ->where('phase', 'eq', 2)
                        ->where('floor', 'eq', $floor)
                        ->select();
                    return \show(1, 'OK', $floor_info, 200);
                    break;
            }
        } else {
            return \show(0, '提交方式不正确', '', 201);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 每间房的详情
     */
    public function room_info()
    {
        $room_id = \input('room_id',501);
        $data = Db::name('ParkRoom pr')
            ->join('EnterpriseList el', 'pr.enterprise_id=el.id','LEFT')
            ->where('phase',2)
            ->where('room_number', $room_id)
            ->field('floor,room_number,area')
            ->select();
        if (empty($data)) {
            return \show(1, 'OK', '请输入正确的房间号', 200);
        } else {
            return \show(1, 'OK', $data, 200);
        }
    }

}