<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/24
 * Time: 9:00
 */

namespace app\api\controller\excel;


use app\api\model\ParkBuilding;
use think\Controller;

/**
 * Class Index
 * @package app\api\controller\excel
 */
class Index extends Controller
{
    /**
     *
     */
    public function enterpriseList()
    {

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
}