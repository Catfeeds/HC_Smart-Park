<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:30
 */

namespace app\api\controller;


use think\Db;

class News extends Common
{
    public function news_list(){
        $list = Db::name('News')->where('news_open','eq',1)->limit('10')->select();
        return $list;
    }
}