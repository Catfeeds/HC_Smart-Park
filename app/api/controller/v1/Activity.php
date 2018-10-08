<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/14
 * Time: 13:44
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;
use app\api\library\exception\ApiException;
use think\Db;

/**
 * Class Activity
 * @package app\api\controller\v1
 * 活动模块
 */
class Activity extends AuthBase
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 活动列表,不带搜索
     */
    public function index()
    {
        $model = new \app\api\model\News();
        $page = \input('page', 1);
        $key = '';
        $news_columnid = 3; //栏目id参见数据表
        $list = $model->getNewsList($page, $key, $news_columnid);
        return \show(1, 'OK', $list, 200);
    }


    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 活动详情+用户是否已报名
     */
    public function read()
    {
        $id = \input('id');//活动id
        $user_id = \input('user_id');
        $new_model = new \app\api\model\News();
        $act_info = $new_model->getNewsDetailById($id);//活动详情
        $apply_info = Db::name('ActivityApply')
            ->where('activity_id', 'eq', $id)
            ->where('user_id', 'eq', $user_id)
            ->value('status');
        if (empty($apply_info))
            $apply_info = 0;
        $act_info['apply_status'] = $apply_info;
        return \show(1, 'OK', $act_info, 200);
    }

    /**
     * @return ApiException|\think\response\Json
     * 活动报名
     */
    public function save()
    {
        $id = \input('id');//活动id
        $user_id = \input('user_id');
        $log = Db::name('ActivityApply')
            ->where('activity_id', 'eq', $id)
            ->where('user_id', 'eq', $user_id)
            ->count();
        if ($log < 1) {
            $sqldata = [
                'activity_id' => $id,
                'user_id' => $user_id,
                'create_time' => \time()
            ];
            $res = Db::name('ActivityApply')->insert($sqldata);
            if ($res) {
                return \show(1, '报名成功');
            } else {
                return \show(0, '报名失败');
            }
        }else{
            return new ApiException('不能重复报名',201);
        }
    }
}