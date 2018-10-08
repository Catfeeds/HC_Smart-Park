<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/29
 * Time: 9:37
 */

namespace app\api\controller\v1;


use app\api\controller\Common;
use app\api\model\PlugAd;
use app\api\model\News;

class PartyNews extends Common
{
    public function index()
    {
        $modelB = new PlugAd();
        $modelN = new News();
        $where = [
            'plug_ad_adtypeid' => 3,  //党风建设banner
        ];
        //轮播图列表
        $banner_list = $modelB->getBannerListByCondition($where);
        $page = \input('page', 1);
        $key = \input('key', '');
        $news_columnid = 1; //党风建设栏目id
        //新闻列表
        $news_list = $modelN->getNewsList($page, $key, $news_columnid);

        $info['banner_list'] = $banner_list;
        $info['news_list'] = $news_list;
        return \show(1, 'OK', $info, '200');
    }
}