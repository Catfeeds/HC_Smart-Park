<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/11
 * Time: 10:06
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;
use app\api\library\exception\ApiException;
use app\api\model\ServiceRepair;
use think\Db;

/**
 * Class Repair
 * @package app\api\controller\v1
 * 报修模块
 */
class Repair extends AuthBase
{
    /**
     *我的报修列表
     */
    public function my_repair()
    {
        $user_id = \input('user_id');
        $page = \input('page', 1);
        $model = new ServiceRepair();
        $list = $model->getRepairList($user_id, $page);
        return \show(1, 'OK', $list, 200);
    }


    /**
     * @return \think\response\Json
     * @throws \Exception
     * 发布报修
     */
    public function save()
    {
        $base64img = \input('image');
        if (!empty($base64img)) {
            $base64img = \json_decode($base64img);
            $pic_url = $this->img_upload($base64img);
        } else {
            $pic_url = '';
        }

        $sqldata = [
            'user_id' => \input('user_id'),
            'title' => \input('title'),
            'content' => \input('content'),
            'pic_url' => \serialize($pic_url),
        ];
        $model = new ServiceRepair();
        $res = $model->allowField(true)->save($sqldata);
        if ($res) {
            return \show('1', '报修成功', $res, 200);
        }
    }

    /**
     * @return ApiException|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 报修详情
     */
    public function read()
    {
        $id = \input('id');//报修单id
        $user_id = \input('user_id');
        $uid = Db::name('ServiceRepair')->where('id', 'eq', $id)->value('user_id');
        if ($uid != $user_id) {
            return new ApiException('身份不对', 201);
        } else {
            $info = \model('ServiceRepair')->where('id', 'eq', $id)->find();
            return \show(1, 'OK', $info, 200);
        }
    }

    /**
     * @return ApiException|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 修改报修状态,撤回或者加急
     */
    public function change_status()
    {
        $id = \input('id');
        $user_id = \input('user_id');
        $status = \input('status');
        $uid = Db::name('ServiceRepair')->where('id', 'eq', $id)->value('user_id');
        if ($uid != $user_id) {
            return new ApiException('身份不对', 201, 0);
        } else {
            $res = Db::name('ServiceRepair')->where('id', 'eq', $id)->setField('status', $status);
            if (!$res) {
                return new ApiException('修改失败', 201);
            } else {
                $info = \model('ServiceRepair')->where('id', 'eq', $id)->find();
                return \show(1, 'OK', $info, 200);
            }
        }
    }
}