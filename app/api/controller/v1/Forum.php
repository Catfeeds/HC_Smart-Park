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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 帖子列表
     */
    public function index()
    {
        $page = \input('page', 1);
        $key = \input('key', '');
        $model = new \app\api\model\News();
        $list = $model->getNewsList($page, $key, 4);
        return \show(1, 'OK', $list, 200);
    }


    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 帖子详情_登录用户是否点赞
     */
    public function read()
    {
        $id = \input('id');
        $uid = \input('user_id');
        $new_model = new \app\api\model\News();
        $data['news_info'] = $new_model->getNewsDetailById($id);

        if (!empty($uid)) {
            $is_zan = Db::name('news_zan')
                ->where('news_id', 'eq', $id)
                ->where('user_id', 'eq', $uid)
                ->count();
            if ($is_zan > 0) {
                $data['is_zan'] = 1;
            } else {
                $data['is_zan'] = 0;
            }
        } else {
            $data['is_zan'] = 0;
        }


        return \show(1, 'OK', $data, 200);
    }
}