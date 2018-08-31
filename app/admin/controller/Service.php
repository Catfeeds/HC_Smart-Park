<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:44
 */

namespace app\admin\controller;


use think\Db;

/**
 * Class Service
 * @package app\admin\controller
 * 物业服务管理控制器
 */
class Service extends Base
{
    /**
     *投诉列表
     */
    public function complaints_list()
    {

    }

    /**
     *处理、回复投诉
     */
    public function compains_reply()
    {

    }

    /**
     *建议列表
     */
    public function suggest_list()
    {

    }

    /**
     *处理，回复建议
     */
    public function suggest_reply()
    {

    }

    /**
     *报修列表
     */
    public function repair_list()
    {

    }

    /**
     *处理报修
     */
    public function repair_handle()
    {

    }

    /**
     *活动列表
     */
    public function activity_list()
    {

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
     *全部删除
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