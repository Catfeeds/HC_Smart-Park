<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:26
 */

namespace app\admin\controller;


use think\Db;
use app\admin\model\Announcement as AnnouncementModel;

/**
 * Class Announcement
 * @package app\admin\controller
 * 公告管理控制器
 */
class Announcement extends Base
{
    /**
     *
     */
    public function index()
    {

    }

    /**
     *公告列表
     */
    public function announcement_list()
    {
        $announcement_model = new AnnouncementModel;
        $list = $announcement_model
            ->order('addtime desc')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign(\compact('list'));
        $this->assign('page', $show);
        return $this->fetch();
    }

    /**
     *执行添加操作（添加页面使用列表页的弹窗形式）
     */
    public function announcement_runadd()
    {
        $sqldata = [
            'title' => \input('title'),
            'content' => \input('content'),
            'publisher_id' => \session('hid'),
            'addtime' => \time()
        ];

        $res = \db('Announcement')->insert($sqldata);
        if ($res) {
            $this->success('发布成功', \url('admin/Announcement/announcement_list'));
        } else {
            $this->error('发布失败', \url('admin/Announcement/announcement_list'));
        }
    }

    /**
     *删除公告
     */
    public function announcement_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('Announcement')->where('id', 'eq', $id)->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Announcement/announcement_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Announcement/announcement_list', array('p' => $p)));
        }
    }


    /**
     *删除全部公告
     */
    public function announcement_alldelete()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除的公告", url('admin/Announcement/announcement_list', array('p' => $p)));
        }
        if (!is_array($ids)) {
            $ids[] = $ids;
        }

        $rst = Db::name('Announcement')->where('id', 'in', $ids)->delete();
        if (!$rst) {
            $this->error("删除失败", url('admin/Announcement/announcement_list', array('p' => $p)));
        } else {
            $this->success("删除成功", url('admin/Announcement/announcement_list', array('p' => $p)));
        }
    }
}