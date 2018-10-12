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
     *财务总览
     */
    public function contract_list()
    {
        $key = \input('key');
        $list = Db::name('EnterpriseBillList ebl')
            ->join('EnterpriseEntryInfo eei', 'ebl.enterprise_id=eei.enterprise_id')
            ->join('EnterpriseBank eb', 'ebl.enterprise_id=eb.enterprise_id')
            ->join('EnterpriseList el', 'ebl.enterprise_id=el.id')
            ->where('el.enterprise_list_name', 'like', "%" . $key . "%")
            ->order('bill_time desc')
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
            ->join('EnterpriseEntryInfo eei', 'ebl.enterprise_id=eei.enterprise_id')
            ->join('EnterpriseBank eb', 'ebl.enterprise_id=eb.enterprise_id')
            ->join('EnterpriseList el', 'ebl.enterprise_id=el.id')
            ->where('el.enterprise_list_name', 'like', "%" . $key . "%")
            ->order('bill_time desc')
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