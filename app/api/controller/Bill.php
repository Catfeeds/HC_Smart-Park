<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/10
 * Time: 14:48
 */

namespace app\api\controller;


use think\Db;

/**
 * Class Bill
 * @package app\api\controller
 * 生成企业账单
 */
class Bill extends Common
{
    /**
     *方法
     */
    public function index()
    {
        $limit_time = '-2 weeks';
        $db = Db::name('EnterpriseEntryInfo');

        //支付时间小于两周的企业的id
        $enterprise_ids = $db->whereTime('pay_time', $limit_time)->column('enterprise_id');
        $length = \count($enterprise_ids);
        for ($i = 0; $i < $length; $i++) {
            //当前企业id是$enterprise_ids[$i]
            //计算物业费
            //查找物业费交费周期

            $property_amount = 1000;
            //计算房租
            //查找房租交费周期
            $rent_amount = 2000;
            //计算空调费用 总额= 面积*单价*交费周期 一天0.45元
            //查找空调费交费周期
            $aircon_amount = 3000;
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
            }
        }
    }
}