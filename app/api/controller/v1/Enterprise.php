<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/3
 * Time: 16:10
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\api\model\EnterpriseList;

/**
 * Class Enterprise
 * @package app\api\controller\v1
 * 企业模块
 */
class Enterprise extends Common
{
    /**
     * @return \think\response\Json
     * 企业列表带搜索
     */
    public function index()
    {
        //页码
        $page = \input('page', '1', 'intval');
        //搜索关键字
        $key = \input('key', '');
        $list = \model('EnterpriseList')->getEnterpriseList($page, $key);
        return \show(1, 'OK', $list,200);
    }


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 企业详情
     */
    public function read()
    {
        $id = \input('id');
        $model = new EnterpriseList();
        $detail = $model->getEnterpriseDetailById($id);
        return \show('1', 'OK',$detail, 200);
    }
}