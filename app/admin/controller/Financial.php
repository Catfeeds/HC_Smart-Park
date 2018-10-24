<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 11:20
 */

namespace app\admin\controller;


use think\Db;

/**
 * Class Financial
 * @package app\admin\controller
 * 财务管理控制器
 */
class Financial extends Base
{
    /**
     *合同管理
     */
    public function contract_list()
    {
        $key = \input('key');
        $list = Db::name('EnterpriseEntryInfo eei')
            ->join('EnterpriseBank eb', 'eei.enterprise_id=eb.enterprise_id')
            ->join('EnterpriseList el', 'eei.enterprise_id=el.id')
            ->join('EnterpriseBillList ebl', 'eei.enterprise_id=ebl.enterprise_id')
            ->where('el.enterprise_list_name', 'like', "%" . $key . "%")
            ->order('enterprise_list_addtime desc')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        if (\request()->isAjax()) {
            return $this->fetch('ajax_contract_list');
        } else {
            return \view();
        }
    }

    /**
     *账单列表
     */
    public function bill_list()
    {
        $key = \input('key');
        $list = Db::name('EnterpriseBillList ebl')
            ->join('EnterpriseEntryInfo eei', 'ebl.enterprise_id=eei.enterprise_id', 'LEFT')
            ->join('EnterpriseBank eb', 'ebl.enterprise_id=eb.enterprise_id', 'LEFT')
            ->join('EnterpriseList el', 'ebl.enterprise_id=el.id', 'LEFT')
            ->where('el.enterprise_list_name', 'like', "%" . $key . "%")
            ->field('ebl.id,el.enterprise_list_name,ebl.rent_amount,ebl.property_amount,ebl.aircon_amount,ebl.discounted_amount,ebl.amount,eei.margin,eei.signed_day,eei.signer,ebl.is_notify,ebl.status')
            ->order('bill_time')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        if (\request()->isAjax()) {
            return $this->fetch('ajax_bill_list');
        } else {
            return \view();
        }
    }

    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     * 发送账单
     */
    public function sendSms()
    {
        $bill_id = \input('id');
        $bill_info = Db::name('EnterpriseBillList')
            ->where('id', $bill_id)
            ->find();
        //先找财务负责人
        $account = Db::name('EnterpriseBank')
            ->where('enterprise_id', $bill_info['enterprise_id'])
            ->value('financial_office_phone');  //根据企业id找到需要发通知的人的手机号
        if (empty($account)) {
            //没有财务负责人,则找企业法人
            $account = Db::name('EnterpriseList')
                ->where('id', $bill_info['enterprise_id'])
                ->value('enterprise_list_legal_phone_number');
            if (empty($account)) {
                $this->error('联系人不存在!');
            }
        }
        $templateCode = 'SMS_148862288';    //短信模板id
        $amount = $bill_info['amount'];     //账单总金额
        $type = 3;
        $res = \sendsms($account, $type, $templateCode, $amount);
        if ($res['code'] == 1) {
            //发送成功后修改通知状态
            Db::name('EnterpriseBillList')->where('id', $bill_id)->setField('is_notify', 1);
            $this->success('发送成功!');
        } else {
            $this->error('发送失败');
        }
    }

    /**
     *添加账单
     */
    public function bill_add()
    {

    }

    /**
     *执行添加操作
     */
    public function bill_runadd()
    {

    }

    /**
     *编辑账单
     */
    public function bill_edit()
    {

    }

    /**
     *执行编辑操作
     */
    public function bill_runedit()
    {

    }

    /**
     *账单状态
     */
    public function bill_status()
    {

    }

    /**
     *删除账单
     */
    public function bill_delete()
    {

    }

    /**
     *发送通知（短信，邮件，微信，站内信等方式）
     */
    public function send_msg()
    {

    }
}