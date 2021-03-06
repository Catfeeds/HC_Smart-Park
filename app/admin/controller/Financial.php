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

        $key = \input('key', '');
        $status = \input('status', '');
        $map = [];
        if ($key != '') {
            $map['el.enterprise_list_name'] = ['like', '%' . $key . '%'];
        }
        if ($status != '') {
            $map['ebl.status'] = $status;
        }
        $list = Db::name('EnterpriseBillList ebl')
            ->join('EnterpriseEntryInfo eei', 'ebl.enterprise_id=eei.enterprise_id', 'LEFT')
            ->join('EnterpriseBank eb', 'ebl.enterprise_id=eb.enterprise_id', 'LEFT')
            ->join('EnterpriseList el', 'ebl.enterprise_id=el.id', 'LEFT')
            ->where('el.id', 'neq', '')
            ->where($map)
            ->field('ebl.id,el.enterprise_list_name,ebl.rent_amount,ebl.property_amount,ebl.aircon_amount,ebl.discounted_amount,ebl.amount,ebl.fee_handler,ebl.invoice_handler,eei.margin,eei.signed_day,eei.signer,ebl.is_notify,ebl.status')
            ->order('bill_time')
            ->paginate(config('paginate.list_rows'));
//        \halt($list);
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
            Db::name('EnterpriseBillList')->where('id', $bill_id)->setField('is_notify', \session('hid'));
            $this->success('发送成功!');
        } else {
            $this->error('发送失败');
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 确认收款操作
     */
    public function paid()
    {
        $bill_id = \input('id');
        $bill_id_check = Db::name('EnterpriseBillList')->where('id', $bill_id)->find();
        if (empty($bill_id_check)) {
            $this->error('该账单不存在');
        } else {
            $fields = [
                'status' => 1,
                'fee_handler' => \session('hid'),
                'fee_handler_time' => \time(),
            ];
            $res = Db::name('EnterpriseBillList')->where('id', $bill_id)->setField($fields);
            if ($res) {
                $this->success('确认收款成功');
            } else {
                $this->error('确认收款失败');
            }
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 确认开票
     */
    public function invoice()
    {
        $bill_id = \input('id');
        $bill_id_check = Db::name('EnterpriseBillList')->where('id', $bill_id)->find();
        if (empty($bill_id_check)) {
            $this->error('该账单不存在');
        } else {
            $fields = [
                'status' => 2,
                'invoice_handler' => \session('hid'),
                'invoice_handler_time' => \time(),
            ];
            $res = Db::name('EnterpriseBillList')->where('id', $bill_id)->setField($fields);
            if ($res) {
                $this->success('确认收款成功');
            } else {
                $this->error('确认收款失败');
            }
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 编辑账单弹窗
     */
    public function bill_edit()
    {
        if (\request()->isAjax()) {
            $bill_id = \input('id');
            $discounted_amount = Db::name('EnterpriseBillList')
                ->where('id', $bill_id)
                ->find();
            $discounted_amount['code'] = 1;
            return \json($discounted_amount);
        } else {
            $this->error('提交方式不正确!');
        }
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 执行编辑账单操作
     */
    public function bill_runedit()
    {
        $bill_info = Db::name('EnterpriseBillList')
            ->where('id', \input('id'))
            ->find();
        if (empty($bill_info)) {
            $this->error('该账单不存在');
        }
        //调整的金额
        $discounted_amount = \input('discounted_amount');
        //写入调整后总金额
        $amount = $bill_info['amount'] + $discounted_amount;
        $fields = [
            'amount' => $amount,
            'discounted_amount'=>\input('discounted_amount'),
            'discounted_amount_reason' => \input('discounted_amount_reason'),
            'discounted_amount_time' => \time(),
        ];

        $res = Db::name('EnterpriseBillList')->where('id', \input('id'))->setField($fields);
        if ($res) {
            $this->success('调整成功!');
        } else {
            $this->error('调整失败!');
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