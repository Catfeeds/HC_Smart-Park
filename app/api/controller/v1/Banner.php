<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:42
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use think\Db;

class Banner extends Common
{
    public function index()
    {
        $list = Db::name('PlugAd')
            ->where('plug_ad_open', 'eq', 1)
            ->order('plug_ad_order desc')
            ->limit('3')->select();
        return \show('1', 'OK', $list, 200);
    }
}