<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 21:53
 */

namespace app\api\controller\v1;

use think\Db;
use app\api\controller\Common;
class Test extends Common
{
    public function index()
    {//首页banner图
        $data['banner_list'] = Db::name('PlugAd')
            ->where('plug_ad_open', 'eq', 1)
            ->limit('3')
            ->select();
        //滚动公告
        $data['announcement_list'] = Db::name('Announcement')
            ->limit('5')
            ->select();

        return \show(200,'OK',$data,200);
    }

    public function update($id = 0)
    {
        return $id;
    }
}