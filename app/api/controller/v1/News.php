<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:30
 */

namespace app\api\controller\v1;


use app\api\library\exception\ApiException;
use think\Db;
use app\api\controller\Common;

/**
 * Class News
 * @package app\api\controller\v1
 * 新闻接口
 */
class News extends Common
{

    /**
     * @return \think\response\Json
     * 新闻列表,带标题搜索功能
     */
    public function index()
    {
        $key = \input('key', '');
        $page = \input('page', 1);
        $list = \model('News')->getNewsList($page, $key, $news_columnid = 2);
        return \show(1, 'OK', $list, 200);
    }


    /**
     * @return ApiException|\think\response\Json
     * @throws \think\Exception
     * 读取新闻详情
     */
    public function read()
    {
        $id = input('id', 0, 'intval');
        $news = \model('News')->getNewsDetailById($id);
        //判断用户是否点赞
        $user_id = \input('user_id', 0);
        $isZan = Db::name('NewsZan')
            ->where('news_id', 'eq', $id)
            ->where('user_id', 'eq', $user_id)
            ->count();
        if ($isZan > 0) {
            $news['iszan'] = 1;
        } else {
            $news['iszan'] = 0;
        }
        if (empty($news)) {
            return new ApiException('新闻不存在', 404);
        } else {
            return \show(1, 'OK', $news, 200);
        }
    }
}