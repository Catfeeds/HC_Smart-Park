<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/15
 * Time: 13:38
 */

namespace app\api\controller\cron;


use app\api\controller\Common;
use think\Db;


/**
 * Class Bill
 * @package app\api\controller\cron
 */
class Bill extends Common
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 此处为自动生成账单方法
     * 根据入驻信息中的支付日期为初始时间计算
     * 财务在后台确认交费后需要修改入驻信息表中的支付时间
     */
    public function index()
    {
        $limit_time = '-2 weeks';
        //两周内需要续费的企业id/s
        $enterprise_ids = Db::name('EnterpriseBillList')->whereTime('bill_time', $limit_time)->column('enterprise_id');
        \halt($enterprise_ids);
        if (empty($enterprise_ids)) {
            return '本次没有新账单!';
        } else {
            $length = \count($enterprise_ids);
            for ($i = 0; $i < $length; $i++) {
                //企业id是$enterprise_ids[$i],查出当前企业的签约信息
                $info = Db::name('EnterpriseEntryInfo')
                    ->where('enterprise_id', 'eq', $enterprise_ids[$i])
                    ->find();
                $room_id = $info['room'];
                //可能存在一起多房,所以转为数组
                $room_id = \explode('|', $room_id);

                //该企业的上次交费信息
                $last_bill_info = Db::name('EnterpriseBillList')
                    ->where('enterprise_id', 'eq', $enterprise_ids[$i])
                    ->order('bill_time desc')
                    ->find();

                $rent_amount = 0;
                $property_amount = 0;
                $aircon_amount = 0;

                foreach ($room_id as $v) {
                    //找出该企业的房间信息
                    $room_info = Db::name('ParkRoom')
                        ->where('phase', 'eq', $info['phase'])
                        ->where('room_number', 'eq', $v)
                        ->find();

                    //如果缴费日期在两星期内就生成房租账单
                    if ($last_bill_info['next_rent_time'] - \time() < 1209600) {
                        //每间房的房租
                        $per_rent = $room_info['price'] * $room_info['area'] * $info['rent_period'];
                        //下次房租费的时间点
                        $next_rent_time = \strtotime('+' . $info['rent_period'] . 'month');
                    } else {
                        $per_rent = 0;
                        $next_rent_time = $info['next_rent_time'];
                    }
                    $rent_amount += $per_rent;      //所有房间的房租

                    //如果缴费日期在两星期内就生成物业费账单
                    if ($last_bill_info['next_rent_time'] - \time() < 1209600) {
                        //每间房的物业费
                        $per_property = $room_info['property'] * $room_info['area'] * $info['property_period'];
                        //下次物业费的时间点
                        $next_property_time = \strtotime('+' . $info['property_period'] . 'month');
                    } else {
                        $per_property = 0;
                        $next_property_time = $info['next_property_time'];
                    }
                    $property_amount += $per_property;//所有房间的物业费

                    if ($last_bill_info['next_rent_time'] - \time() < 1209600) {
                        //每间房的空调费
                        $per_aircon = $room_info['aircon'] * $room_info['area'] * $info['air_conditioner_period'];
                        //下次空调费的时间点
                        $next_aircon_time = \strtotime('+' . $info['air_conditioner_period'] . 'month');
                    } else {
                        $per_aircon = 0;
                        $next_aircon_time = $info['next_aircon_time'];
                    }
                    $aircon_amount += $per_aircon;  //所有房间的空调费
                }
                //入库数据
                $sqldata = [
                    'enterprise_id' => $enterprise_ids[$i],
                    'rent_amount' => $rent_amount,
                    'property_amount' => $property_amount,
                    'aircon_amount' => $aircon_amount,
                    'amount' => $rent_amount + $property_amount + $aircon_amount,
                    'discounted_amount' => 0,
                    'bill_time' => \time(),
                    'next_rent_time' => $next_rent_time,
                    'next_property_time' => $next_property_time,
                    'next_aircon_time' => $next_aircon_time,
                    'is_notify' => 0,
                    'status' => 0
                ];
                //账单周期至少一个月,所以不生成一个月内相同信息的账单
                $rst = Db::name('EnterpriseBillList')
                    ->where('enterprise_id', 'eq', $enterprise_ids[$i])
                    ->where('rent_amount', 'eq', $last_bill_info['rent_amount'])
                    ->where('property_amount', 'eq', $last_bill_info['property_amount'])
                    ->where('aircon_amount', 'eq', $last_bill_info['aircon_amount'])
                    ->whereTime('bill_time', 'month')
                    ->count();
                if ($rst < 1 && $sqldata['amount'] > 0) {
                    Db::name('EnterpriseBillList')->insert($sqldata);
                    return \show('1', '出账成功', $sqldata, '200');
                } else {
                    return '本次没有新账单';
                }
            }
        }
    }
}