<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/21
 * Time: 17:12
 */

namespace app\api\controller;


class Version extends Common
{
    public function index()
    {
        $version_info = \config('app_version');
        if (\strtotime($version_info['publish_time']) > \strtotime(\input('publish_time'))) {
            return \show(1, '有更新哟!', $version_info, 200);
        } else {
            return \show(0, '已是最新版本', '', 200);
        }
    }
}