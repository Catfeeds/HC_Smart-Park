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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 新闻列表,带标题搜索功能
     */
    public function index()
    {
        //页码
        $page = \input('page', '1', 'intval');
        //搜索关键字
        $key = \input('key', '');
        $where['news_title'] = ['like', '%' . $key . '%'];
        $list = Db::name('News')
            ->where($where)
            ->where('news_open', 'eq', 1)
            ->field('n_id,news_title,news_columnid,news_hits,news_img,news_time')
            ->order('news_time desc')
            ->page($page, '10')
            ->select();
        return \show('200', 'OK', $list);
    }

    /**
     * @return ApiException
     * 新闻详情页
     */
    public function read()
    {
        $id = input('id', 0, 'intval');

        $news = \model('News')->getNewsDetailById($id);
        if (empty($news)) {
            return new ApiException('error', 404);
        }
    }
}