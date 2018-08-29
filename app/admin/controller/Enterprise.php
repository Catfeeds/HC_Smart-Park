<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 9:54
 */

namespace app\admin\controller;


/**
 * Class Enterprise
 * @package app\admin\controller
 * 企业管理控制器
 */
class Enterprise extends Base
{
    /**
     * @return string
     * 园区入驻企业信息总览
     */
    public function index()
    {
        return "企业总览";
    }

    /**
     *企业列表
     */
    public function enterprise_list()
    {
        $key = input('key');
        $opentype_check = input('opentype_check', '');
        $where = array();
        if ($opentype_check !== '') {
            $where['enterprise_list_open'] = $opentype_check;
        }

        $enterprise_list = \db('EnterpriseList')
            ->where($where)
            ->where('enterprise_list_name', 'like', "%" . $key . "%")
            ->where('is_delete', 'neq', 1)
            ->order('enterprise_list_addtime desc')
            ->paginate(config('paginate.list_rows'), false, ['query' => get_query()]);
        $show = $enterprise_list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('opentype_check', $opentype_check);
        $this->assign('enterprise_list', $enterprise_list);
        $this->assign('page', $show);
        $this->assign('val', $key);
        if (request()->isAjax()) {
            return $this->fetch('ajax_enterprise_list');
        } else {
            return $this->fetch();
        }
        return $this->fetch();
    }

    /**
     *添加企业的页面（包括基本信息，经济信息，合同信息等，用标检切换展示）
     */
    public function enterprise_add()
    {

    }

    //企业信息分标签录入分表储存，故将add操作分成多个。

    /**
     *添加企业基本信息
     */
    public function enterprise_basic_information_runadd()
    {

    }

    /**
     *添加企业合同信息
     */
    public function enterprise_contract_information_runadd()
    {

    }

    /**
     *添加企业经济信息
     */
    public function enterprise_economic_information_runadd()
    {

    }

    /**
     *编辑企业信息的页面
     */
    public function enterprise_edit()
    {

    }

    /**
     *执行编辑操作
     */
    public function enterprise_runedit()
    {

    }

    /**
     *编辑企业基本信息
     */
    public function enterprise_basic_information_runedit()
    {

    }

    /**
     *编辑企业合同信息
     */
    public function enterprise_contract_information_runedit()
    {

    }

    /**
     *编辑企业经济信息
     */
    public function enterprise_economic_information_runedit()
    {

    }

    /**
     *修改企业状态
     */
    public function enterprise_status()
    {
        $id = input('x');
        $enterprise_model = \db('EnterpriseList');
        $status = $enterprise_model->where(array('id' => $id))->value('enterprise_list_open');//判断当前状态情况
        if ($status == 1) {
            $statedata = array('enterprise_list_open' => 0);
            $enterprise_model->where(array('id' => $id))->setField($statedata);
            $this->success('状态禁止');
        } else {
            $statedata = array('enterprise_list_open' => 1);
            $enterprise_model->where(array('id' => $id))->setField($statedata);
            $this->success('状态开启');
        }
    }

    /**
     *删除企业
     */
    public function enterprise_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('EnterpriseList')->where('id', 'eq', $id)->setField('is_delete', 1);
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Enterprise/enterprise_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Enterprise/enterprise_list', array('p' => $p)));
        }
    }
}