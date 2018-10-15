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
 * Class Bill1
 * @package app\api\controller\v1
 * 生成企业账单
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
        $db = Db::name('EnterpriseEntryInfo');

        //支付时间小于两周的企业的id
        $enterprise_ids = $db->whereTime('pay_time', $limit_time)->column('enterprise_id');
        $length = \count($enterprise_ids);
        for ($i = 0; $i < $length; $i++) {
            //企业id是$enterprise_ids[$i],查出当前企业的签约信息
            $info = $db->where('enterprise_id', 'eq', $enterprise_ids[$i])->find();

            //计算物业费=物业费*面积*交费周期
            $property_amount = $info['property_square'] * $info['area'] * $info['property_period'];

            //计算房租=单价*面积*交费周期
            $rent_amount = $info['rent_square'] * $info['area'] * $info['rent_period'];

            //计算空调费用
            $aircon_amount = 0.45 * $info['area'] * $info['air_conditioner_period'];

            //入库数据
            $sqldata = [
                'enterprise_id' => $enterprise_ids[$i],
                'rent_amount' => $rent_amount,
                'property_amount' => $property_amount,
                'aircon_amount' => $aircon_amount,
                'amount' => $rent_amount + $property_amount + $aircon_amount,
                'bill_time' => \time(),
                'is_notify' => 0,
                'status' => 0
            ];
            //不生成一个月内相同信息的账单
            $rst = Db::name('EnterpriseBillList')
                ->where('enterprise_id', $enterprise_ids[$i])
                ->where('rent_amount', $rent_amount)
                ->where('property_amount', $property_amount)
                ->where('aircon_amount', $aircon_amount)
                ->whereTime('bill_time', '-1 month')
                ->count();
            if ($rst < 1) {
                Db::name('EnterpriseBillList')->insert($sqldata);
                return \show('1', 'OK','','200');
            }
        }
    }
}