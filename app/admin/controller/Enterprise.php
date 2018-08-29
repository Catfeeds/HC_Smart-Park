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
    public function enterprise_basic_information_add()
    {

    }

    /**
     *添加企业合同信息
     */
    public function enterprise_contract_information_add()
    {

    }

    /**
     *添加企业经济信息
     */
    public function enterprise_economic_information_add()
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
     *修改企业状态
     */
    public function enterprise_stauts()
    {

    }

    /**
     *删除企业
     */
    public function enterprise_delete()
    {

    }
}