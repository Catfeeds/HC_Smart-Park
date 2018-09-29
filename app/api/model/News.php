<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/1
 * Time: 11:32
 */

namespace app\api\model;


use think\Db;
use think\Model;
use think\Request;

/**
 * Class News
 * @package app\api\model
 */
class News extends Model
{
    /**
     * @var array
     */
    protected $visible = [
        'n_id',
        'news_title',
        'news_auto',
        'news_source',
        'news_content',
        'news_hold_time',
        'news_hold_place',
        'news_hold_number',
        'news_scontent',
        'news_hits',
        'news_zan',
        'news_img',
        'news_pic_allurl',
        'news_pic_content',
        'news_time',
        'iszan',
        'author',
        'apply_status'
    ];

    /**
     * @param $news_time
     * @return false|string
     * 新闻时间读取器
     */
    public function getNewsTimeAttr($news_time)
    {
        return date('Y-m-d H:i:s', $news_time);
    }

    /**
     * @param $news_hold_time
     * @return false|string
     * 活动时间读取器
     */
    public function getNewsHoldTimeAttr($news_hold_time)
    {
        return date('Y-m-d H:i:s', $news_hold_time);
    }

    /**
     * @param $news_auto
     * @return mixed
     * 新闻作者读取器
     */
    public function getNewsAutoAttr($news_auto)
    {
        return $news_auto = \model('Admin')
            ->where('admin_id', $news_auto)
            ->value('admin_username');
    }

    /**
     * @param $news_img
     * @return string
     * 返回完整的图片路径
     */
    public function getNewsImgAttr($news_img)
    {
        $reqeust = Request::instance();
        if (!empty($news_img)) {
            return $reqeust->domain() . $news_img;
        } else {
            return 'http://ov7uxfxnm.bkt.clouddn.com/no_news.webp';
        }
    }

    /**
     * @param $content
     * @return string
     * 拼接文章内容里的图片地址
     */
    public function getNewsContentAttr($content)
    {
        $img_url = \request()->domain() . '/data';
        $replace_pairs = ['/data' => $img_url];
        return \strtr($content, $replace_pairs);
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * app首页新闻列表(园区新闻)
     */
    public function getIndexNewsList()
    {
        $where = [
            'news_open' => 1,
            'news_back' => 0,
            'news_columnid' => 2,     //置顶栏目ID
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
     * 获取指定栏目的列表+总条数
     */
    public function getNewsList($page, $key, $news_columnid)
    {

        $where = [
            'news_title' => ['like', '%' . $key . '%'],
            'news_columnid' => $news_columnid,     //栏目ID
            'news_open' => 1,         //已审状态
            'news_back' => 0          //没有被删除
        ];
        $count = $this->where($where)->count();
        $data =
            $this::with('author')->where($where)
                ->order('news_time desc')
                ->page($page, 2)
                ->select();
        $da['total_num'] = $count;
        $da['data'] = $data;
        return $da;
    }

    /**
     * @param $page
     * @param $uid
     * @param $c_id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据用户名和栏目id获取文章列表
     */
    public function getNewsListByUserId($page, $uid, $c_id)
    {
        $map = [
            'news_auto' => $uid,
            'news_columnid' => $c_id
        ];
        $count = $this->where($map)->count();
        $list = $this->where($map)
            ->order('news_time desc')
            ->page($page, 5)
            ->select();
        $data['total_num'] = $count;
        $data['data'] = $list;
        return $data;
    }


    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取文章详情
     */
    public function getNewsDetailById($id)
    {
        //给阅读数+1
        Db::name('News')
            ->where('n_id', 'eq', $id)
            ->setInc('news_hits');
        $detail = $this::with('author')
            ->where('n_id', 'eq', $id)
            ->find();
        //如果设置了显示时间,则发布时间为显示时间
        if (!empty($detail['news_extra'])) {
            $detail['news_time'] = \json_decode($detail['news_extra'])->showdate;
        }
        return $detail;
    }

    /**
     * @return \think\model\relation\BelongsTo
     * 关联文章发布者信息
     */
    public function author()
    {
        return $this->
        belongsTo('MemberList', 'news_auto', 'member_list_id')
            ->setEagerlyType(0);
    }
}