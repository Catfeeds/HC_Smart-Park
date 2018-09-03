<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/1
 * Time: 11:32
 */

namespace app\api\model;


use think\Model;

/**
 * Class News
 * @package app\api\model
 */
class News extends Model
{
    /**
     * @param $news_time
     * @return false|string
     * 新闻时间读取器
     */
    protected function getNewsTimeAttr($news_time)
    {
        return date('Y-m-d', $news_time);
    }

    /**
     * @param $news_auto
     * @return mixed
     * 新闻作者读取器
     */
    protected function getNewsAutoAttr($news_auto)
    {
        return $news_auto = \model('Admin')->where('admin_id', $news_auto)->value('admin_username');
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * app首页新闻列表
     */
    public function getIndexNewsList()
    {
        $where = [
            'news_open' => 1,
            'news_back' => 0
        ];
        return $this
            ->where($where)
            ->field('n_id,news_title,news_img,news_hits,news_time,news_scontent')
            ->order('news_time desc')
            ->limit(5)
            ->select();
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取新闻列表
     */
    public function getNewsList()
    {
        //页码
        $page = \input('page', '1', 'intval');
        //搜索关键字
        $key = \input('key', '');
        $where['news_title'] = ['like', '%' . $key . '%'];
        $where = [
            'news_columnid' => 1,     //栏目ID
            'news_open' => 1,         //已审状态
            'news_back' => 0          //没有被删除
        ];
        return $this->where($where)
            ->field('n_id,news_title,news_columnid,news_hits,news_img,news_time')
            ->order('news_time desc')
            ->page($page, '10')
            ->select();
        return \show('200', 'OK', $list);
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取新闻详情
     */
    public function getNewsDetailById($id)
    {
        return $detail = $this
            ->where('n_id', 'eq', $id)
            ->field('news_title,news_time,news_auto,news_hits,news_source,news_content')
            ->find();
    }
}