<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        $banner_list = Db::name('PlugAd')->where('plug_ad_open','eq',1)->limit('3')->select();
        $announcement_list = Db::name('News')->where('news_open','eq',1)->where('news_columnid','eq','3')->limit('5')->select();
    }
}
