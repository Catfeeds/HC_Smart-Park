<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 9:54
 */

namespace app\admin\controller;


use app\admin\model\EnterpriseList;
use think\Db;

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
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 企业详情
     */
    public function enterprise_info()
    {
        $id = \input('id');
        //基本信息
        $basic_info = Db::name('EnterpriseList')->where('id', $id)->find();
        //业务信息
        $business_info = Db::name('EnterpriseBusiness')->where('enterprise_id', $id)->find();
        //联系信息
        $contact_info = Db::name('EnterpriseContact')->where('enterprise_id', $id)->find();
        //银行信息
        $bank_info = Db::name('EnterpriseBank')->where('enterprise_id', $id)->find();
        //入驻信息
        $entry_info = Db::name('EnterpriseEntryInfo')->where('enterprise_id', $id)->find();

        $info = $basic_info + $business_info + $contact_info + $bank_info + $entry_info;
        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     *添加企业的页面（包括基本信息，经济信息，合同信息等，用标检切换展示）
     */
    public function enterprise_add()
    {
        return \view();
    }

    /**
     *执行添加操作
     * 1,提交的数据中如果没有表单最后一项:confirmer,说明数据没有提交完全则不进行添加操作.
     * 2,confirmer数据存在则说明入库完成,返回成功提示.
     * 因为提交页面写法的原因,也是因为没时间慢慢写数据验证和数据库操作,所以采取了这种做法.有时间重写.
     */
    public function enterprise_runadd()
    {
        $enterprise_info = \input();
        if (!\request()->isPost()) {
            $this->error('提交方式不正确');
        } else {
            if ($enterprise_info['confirmer'] != '') {
                //企业基本信息写入
                $enterprise_info['enterprise_list_legal_setup_day'] = \strtotime($enterprise_info['enterprise_list_legal_setup_day']);//成立日期转时间戳
                $enterprise_info['enterprise_list_addtime'] = \time();
                //企业码
                $enterprise_info['enterprise_list_code'] = substr(md5(microtime(true)), 0, 6);
                $enterprise_name_count = Db::name('EnterpriseList')
                    ->where('enterprise_list_name', 'eq', $enterprise_info['enterprise_list_name'])
                    ->count();
                if ($enterprise_name_count > 0) {
                    $this->error('企业名已存在');
                }
                //插入企业基本信息表并返回企业id
                $modle = new EnterpriseList();
                $enterprise_id = $modle->allowField(true)->save($enterprise_info);

                //企业ID
                $enterprise_info['enterprise_id'] = $modle->id;
                if (empty($enterprise_info['enterprise_id'])) {
                    $this->error('添加失败');
                }

                //企业业务信息写入
                \model('EnterpriseBusiness')->allowField(true)->save($enterprise_info);
                //企业联系信息写入
                \model('EnterpriseContact')->allowField(true)->save($enterprise_info);
                //企业银行信息写入
                \model('EnterpriseBank')->allowField(true)->save($enterprise_info);
                //企业入驻信息写入
                $enterprise_info['signed_day'] = \strtotime($enterprise_info['signed_day']);        //签订日期转时间戳
                $enterprise_info['pay_time'] = \strtotime($enterprise_info['pay_time']);        //支付时间转时间戳
                \model('EnterpriseEntryInfo')->allowField(true)->save($enterprise_info);

                //入库之后找出需要的信息进行相关操作
                $info = Db::name('EnterpriseEntryInfo')
                    ->where('enterprise_id', $enterprise_id)
                    ->field('confirmer,room')
                    ->find();

                //根据企业房间号,需要更改房源的状态
                $room_num = \trim($info['room']);
                Db::name('ParkRoom')->where('room_number', 'eq', $room_num)->setField('status', 1);
                if (empty($info['confirmer'])) {
                    $this->error('添加失败');
                } else {
                    $this->success('添加成功');
                }
            }
        }
    }

    /**
     *编辑企业信息的页面
     */
    public function enterprise_edit()
    {
        $id = \input('id');
        //基本信息
        $basic_info = Db::name('EnterpriseList')->where('id', $id)->find();
        //业务信息
        $business_info = Db::name('EnterpriseBusiness')->where('enterprise_id', $id)->find();
        //联系信息
        $contact_info = Db::name('EnterpriseContact')->where('enterprise_id', $id)->find();
        //银行信息
        $bank_info = Db::name('EnterpriseBank')->where('enterprise_id', $id)->find();
        //入驻信息
        $entry_info = Db::name('EnterpriseEntryInfo')->where('enterprise_id', $id)->find();

        $info = $basic_info + $business_info + $contact_info + $bank_info + $entry_info;
        $this->assign('info', $info);
        return \view();
    }

    /**
     *执行编辑操作
     */
    public function enterprise_runedit()
    {
        $data = \input();
        $data['enterprise_list_legal_setup_day'] = \strtotime($data['enterprise_list_legal_setup_day']);//成立日期转时间戳
        $data['signed_day'] = \strtotime($data['signed_day']);        //签订日期转时间戳
        $data['pay_time'] = \strtotime($data['pay_time']);        //支付时间转时间戳
        \model('EnterpriseList')->allowField(true)->save($data, ['id' => $data['id']]);
        \model('EnterpriseBusiness')->allowField(true)->save($data, ['enterprise_id' => $data['id']]);
        \model('EnterpriseContact')->allowField(true)->save($data, ['enterprise_id' => $data['id']]);
        \model('EnterpriseBank')->allowField(true)->save($data, ['enterprise_id' => $data['id']]);
        \model('EnterpriseEntryInfo')->allowField(true)->save($data, ['enterprise_id' => $data['id']]);

        //入库之后找出需要的信息进行相关操作
        $info = Db::name('EnterpriseEntryInfo')
            ->where('enterprise_id', $data['id'])
            ->field('confirmer,room')
            ->find();
        //根据企业房间号,需要更改房源的状态
        $room_num = \trim($info['room']);
        Db::name('ParkRoom')->where('room_number', 'eq', $room_num)->setField('status', 1);
        if (empty($info['confirmer'])) {
            $this->error('修改失败');
        } else {
            $this->success('修改成功');
        }
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