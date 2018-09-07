<?php

namespace app\api\controller\v1;

use think\Request;
use app\api\controller\Common;

/**
 * Class index
 * @package app\api\controller
 * app首页接口
 */
class Index extends Common
{

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        //首页banner图
        $data['banner_list'] = \model('PlugAd')->getHeadBanner();
        //滚动公告
        $data['announcement_list'] = \model('Announcement')->getIndexAnnouncementList();
        //推广广告
        $data['ad_list'] = \model('PlugAd')->getMiddleBanner();
        //新闻列表
        $data['news_list'] = \model('News')->getIndexNewsList();
        return \show(1, 'OK', $data, 200);

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
