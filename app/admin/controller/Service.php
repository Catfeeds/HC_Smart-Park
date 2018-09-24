<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:44
 */

namespace app\admin\controller;


use app\admin\model\ServiceRepair;
use think\Db;

/**
 * Class Service
 * @package app\admin\controller
 * 物业服务管理控制器
 */
class Service extends Base
{
    /**
     *投诉建议列表
     */
    public function complaints_list()
    {
        $list = Db::name('ServiceComplains')
            ->order('create_time')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('page', $show);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     *处理、回复投诉
     */
    public function compains_reply()
    {

    }

    /**
     *删除投诉建议
     */
    public function complains_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('ServiceComplains')->where('id', 'eq', $id)->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Service/complaints_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Service/complaints_list', array('p' => $p)));
        }
    }

    /**
     *全部删除
     */
    public function complains_alldelete()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除的公告", url('admin/Service/complaints_list', array('p' => $p)));
        }
        if (!is_array($ids)) {
            $ids[] = $ids;
        }

        $rst = Db::name('ServiceComplains')->where('id', 'in', $ids)->delete();
        if (!$rst) {
            $this->error("删除失败", url('admin/Service/complaints_list', array('p' => $p)));
        } else {
            $this->success("删除成功", url('admin/Service/complaints_list', array('p' => $p)));
        }
    }

    /**
     *报修列表
     */
    public function repair_list()
    {
        $model = new ServiceRepair();
        $list = $model
            ->order('create_time desc')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();

        $this->assign('page', $show);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 删除报修
     */
    public function repair_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('ServiceRepair')->where('id', 'eq', $id)->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Service/Repair_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Service/Repair_list', array('p' => $p)));
        }
    }

    /**
     *全部删除
     */
    public function repair_alldelete()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除的报修", url('admin/Service/repair_list', array('p' => $p)));
        }
        if (!is_array($ids)) {
            $ids[] = $ids;
        }

        $rst = Db::name('ServiceRepair')->where('id', 'in', $ids)->delete();
        if (!$rst) {
            $this->error("删除失败", url('admin/Service/repair_list', array('p' => $p)));
        } else {
            $this->success("删除成功", url('admin/Service/repair_list', array('p' => $p)));
        }
    }

    /**
     *处理报修
     */
    public function repair_handle()
    {

    }

    /**
     *活动报名列表
     */
    public function activity_list()
    {

        return $this->fetch();
    }

    /**
     *添加活动-页面
     */
    public function activity_add()
    {

    }

    /**
     *添加活动-操作
     */
    public function activity_runadd()
    {

    }

    /**
     *编辑活动-页面
     */
    public function activity_edit()
    {

    }

    /**
     *编辑活动-操作
     */
    public function activity_runedit()
    {

    }

    /**
     *修改活动状态
     */
    public function activity_status()
    {

    }

    /**
     *删除活动
     */
    public function activity_delete()
    {

    }

    /**
     *待处理事件列表
     */
    public function to_do_list()
    {

    }

    /**
     *会议室预约列表
     */
    public function meeting_room_order_list()
    {

    }

    /**
     *便民热线
     */
    public function hotline_list()
    {
        $list = \db('ServiceHotline')
            ->where('status', 'eq', '1')
            ->order('addtime desc')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);

        $this->assign([
            'list' => $list,
            'page' => $show
        ]);
        return $this->fetch();
    }

    /**
     *添加热线
     */
    public function hotline_runadd()
    {
        $sqldata = [
            'name' => \input('name'),
            'phone_number' => \input('phone_number'),
            'addtime' => \time()
        ];

        $res = Db::name('ServiceHotline')->insert($sqldata);
        if ($res) {
            $this->success('添加成功', \url('admin/Service/hotline_list'));
        } else {
            $this->error('添加失败', \url('admin/Service/hotline_list'));
        }
    }

    /**
     *删除热线
     */
    public function hotline_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('ServiceHotline')->where('id', 'eq', $id)->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Service/hotline_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Service/hotline_list', array('p' => $p)));
        }
    }

    /**
     *热线全部删除
     */
    public function hotline_alldelete()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除的公告", url('admin/Service/hotline_list', array('p' => $p)));
        }
        if (!is_array($ids)) {
            $ids[] = $ids;
        }

        $rst = Db::name('ServiceHotline')->where('id', 'in', $ids)->delete();
        if (!$rst) {
            $this->error("删除失败", url('admin/Service/hotline_list', array('p' => $p)));
        } else {
            $this->success("删除成功", url('admin/Service/hotline_list', array('p' => $p)));
        }
    }
}