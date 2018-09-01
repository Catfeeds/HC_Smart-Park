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
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 首页新闻列表
     */
    public function getIndexNewsList()
    {
        $where = [
            'news_columnid' => 1,     //栏目ID
            'news_open' => 1,         //已审状态
            'news_back' => 0          //没有被删除
        ];
        return $this->where($where)
            ->field('n_id,news_title,news_img')
            ->limit(5)
            ->select();
    }

    public function getNewsDetailById($id)
    {
        return $detail = $this->where('n_id', 'eq', $id)->field('news_title,news_time,news_auto,news_hits,news_source,news_content')->find();
    }
}