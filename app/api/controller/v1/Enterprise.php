<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/3
 * Time: 16:10
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

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

    public function read()
    {
        $id = \input('id');
        $detail = \model('EnterpriseList')->getEnterpriseDetailById($id);
        return \show('1', 'OK',$detail, 200);
    }
}