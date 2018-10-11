<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:37
 */

namespace app\admin\controller;

use app\library\event\PushEvent;
use think\Db;

/**
 * Class Webmsg
 * @package app\admin\controller
 * 站内信控制器
 */
class WebMsgLog extends Base
{
    /**
     * @return mixed
     * @throws \think\exception\DbException
     * 站内信列表
     */
    public function log_list()
    {
        $list = \db('WebMsgLog')
            ->paginate(config('paginate.list_rows'));
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('page', $show);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 删除站内信
     */
    public function log_delete()
    {
        $p = input('p');
        $id = \input('id');
        $rst = \db('WebMsgLog')->where('id', 'eq', $id)->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/WebMsgLog/log_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/WebMsgLog/log_list', array('p' => $p)));
        }
    }

    /**
     *站内信全删
     */
    public function log_alldelete()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除的站内信", url('admin/WebMsgLog/log_list', array('p' => $p)));
        }
        if (!is_array($ids)) {
            $ids[] = $ids;
        }

        $rst = Db::name('WebMsgLog')->where('id', 'in', $ids)->delete();
        if (!$rst) {
            $this->error("删除失败", url('admin/WebMsgLog/log_list', array('p' => $p)));
        } else {
            $this->success("删除成功", url('admin/WebMsgLog/log_list', array('p' => $p)));
        }
    }


    /**
     *推送消息
     */
    public function pushMsg()
    {
        $msg = \input('msg');
        $toid = \input('toid');
        $fromid = \session('hid');
        $type = \input('type');
        $res = \pushWebMsg($toid, $fromid, $msg,$type);
        return $res;
    }

    /**
     * 推送目标页
     *
     * @return \think\response\View
     */
    public function targetPage()
    {
        return view();
    }
}