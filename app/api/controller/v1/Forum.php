<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/17
 * Time: 11:08
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Db;

/**
 * Class Forum
 * @package app\api\controller\v1
 * 论坛社区
 */
class Forum extends Common
{
    /**
     * @return \think\response\Json
     * 帖子列表
     */
    public function index()
    {
        $page = \input('page', 1);
        $key = \input('key', '');
        $list = \model('News')->getNewsList($page, $key, 4);
        return \show(1, 'OK', $list, 200);
    }

    /**
     * @return mixed
     * 帖子详情
     */
    public function read()
    {
        $id = \input('id');
        return \model('News')->getNewsDetailById($id);
    }
}