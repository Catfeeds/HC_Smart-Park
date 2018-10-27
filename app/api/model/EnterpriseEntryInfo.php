<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/28
 * Time: 16:27
 */

namespace app\api\model;


use think\Db;
use think\Model;

/**
 * Class EnterpriseEntryInfo
 * @package app\api\model
 */
class EnterpriseEntryInfo extends Model
{
    /**
     * @param $room
     * @return string
     * 返回拼接好的公司地址
     */
    public function getRoomAttr($room)
    {
        $address = '淮安市通源路9号海创空间大厦' . $room . '室';
        return $address;
    }

    /**
     * @param $time
     * @return false|string
     * 格式化的签订日期
     */
    public function getSignedDayAttr($time)
    {
        return \date('Y-m-d', $time);
    }

    /**
     * @param $time
     * @return false|string
     * 格式化的支付日期
     */
    public function getPayTimeAttr($time)
    {
        return \date('Y-m-d H:i:s', $time);
    }

    /**
     * @param $phase
     * @return mixed
     * 获取楼宇的中文名
     */
    public function getPhaseAttr($phase)
    {
        $name = Db::name('ParkBuilding')->where('id', 'eq', $phase)->value('name');
        return $name;
    }

    /**
     * @param $decorate
     * @return string
     * 返回装修状态
     */
    public function getDecorateAttr($decorate)
    {
        if ($decorate == 1) {
            $value = '毛坯';
            return $value;
        } elseif ($decorate == 2) {
            $value = '简装';
            return $value;
        }
    }

    /**
     * @param $pic
     * @return string
     * 返回企业的租房合同
     */
    public function getContractImgAttr($pic)
    {
        if (!empty($pic)) {
            return \get_app_imgurl($pic);
        } else {
            return '';
        }
    }

    /**
     * @param $pics
     * @return array|string
     * 返回租房合同完整地址
     */
    public function getPicManyImgAttr($pics)
    {
        if (empty($pics)) {
            return '';
        } else {
            $arr = \explode(',', $pics);
            foreach ($arr as &$v) {
                if (!empty($v)) {
                    $v = \request()->domain() . $v;
                }
            }
            return \array_filter($arr);
        }
    }
}