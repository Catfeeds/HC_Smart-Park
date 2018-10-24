<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/24
 * Time: 9:00
 */

namespace app\api\controller\excel;


use app\api\model\EnterpriseList;
use app\api\model\ParkBuilding;
use app\api\model\ParkRoom;
use think\Controller;

/**
 * Class Index
 * @package app\api\controller\excel
 */
class Index extends Controller
{

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 企业列表
     */
    public function enterpriseList()
    {
        //页码
        $page = \input('page', '1', 'intval');
        //搜索关键字
        $key = \input('key', '');
        $model = new EnterpriseList();
        $list = $model->getEnterpriseList($page, $key);
        $data = [];
        foreach ($list as $k => $v) {
            $data[$k]['企业ID'] = $v['id'];
            $data[$k]['企业名称'] = $v['enterprise_list_name'];
            $data[$k]['房间号'] = $v['entry_info']['room'];
            $data[$k]['邀请码'] = $v['enterprise_list_code'];
        }
        $name = '入驻企业列表';
        $header = ['企业ID', '企业名称', '房间号', '邀请码'];
        \ExcelPull($name, $header, $data);
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 导出楼宇列表
     */
    public function buildingList()
    {
        $model = new ParkBuilding();
        $list = $model->select();
        $data = [];
        foreach ($list as $k => $v) {
            $data[$k]['楼宇ID'] = $v['id'];
            $data[$k]['楼宇名称'] = $v['name'];
            $data[$k]['状态'] = $v['status'];
        }
        $name = '楼宇列表';
        $header = ['楼宇ID', '楼宇名称', '楼宇状态'];
        \ExcelPull($name, $header, $data);
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 导出房源列表
     */
    public function roomList()
    {
        $model = new ParkRoom();
        $list = $model->getParkRoomList();
        $data = [];
        foreach ($list as $k => $v) {
            $data[$k]['园区'] = $v['phase'];
            $data[$k]['楼层'] = $v['floor'];
            $data[$k]['房间号'] = $v['room_number'];
            $data[$k]['面积'] = $v['area'];
            $data[$k]['房租'] = $v['price'];
            $data[$k]['物业费'] = $v['property'];
            $data[$k]['空调费'] = $v['aircon'];
            $data[$k]['装修'] = $v['decoration'];
            $data[$k]['入驻企业'] = $v['enterprise_list']['enterprise_list_name'];
            $data[$k]['状态'] = $v['status'];
        }

        $name = '房源列表';
        $header = ['园区', '楼层', '房间号', '面积', '房租', '物业费', '空调费', '装修', '入驻企业', '状态'];
        \ExcelPull($name, $header, $data);
    }
}