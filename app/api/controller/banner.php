<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:42
 */

namespace app\api\controller;


use think\Db;

class banner extends Common
{
    public function banner_list(){
        $list = Db::name('PlugAd')->where('plug_ad_open','eq',1)->limit('3')->select();
        return $list;
    }
}