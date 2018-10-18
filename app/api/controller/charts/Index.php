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

        //一企多房的情况!!!!需要改
        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('ParkRoom')->where('entry_time', 'between time', [$m_s, $m_e])->count();
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

    public function one_floor_entry()
    {
        for ($i = 5; $i < 24; $i++) {
            $data[] = Db::name('ParkRoom')
                ->where('phase', 'eq', 2)   //默认为海创二期大楼
                ->where('floor', 'eq', $i)
                ->where('status', 'eq', 1)
                ->count();
        }
        return ['data' => $data];
    }
}