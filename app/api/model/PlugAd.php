<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 22:46
 */

namespace app\api\model;


use think\Model;
use think\Request;

/**
 * Class PlugAd
 * @package app\api\model
 * 轮播图模型
 */
class PlugAd extends Model
{
    /**
     * @var array
     * 设置显示字段
     */
    protected $visible = [
        'plug_ad_id',
        'plug_ad_name',
        'plug_ad_pic',
        'plug_ad_url',
        'plug_ad_content',
        'plug_ad_addtime'
    ];

    /**
     * @param $plug_ad_addtime
     * @return false|string
     * 返回格式化时间
     */
    public function getPlugAdAddTimeAttr($plug_ad_addtime)
    {
        return \date('Y-m-d H:i:s', $plug_ad_addtime);
    }

    /**
     * @param $plug_ad_pic
     * @return string
     * 返回完整的图片路径,不需要客户端再拼接
     */
    public function getPlugAdPicAttr($plug_ad_pic)
    {
        return \get_app_imgurl($plug_ad_pic);
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * app顶部banner
     */
    public function getHeadBanner()
    {
        $where = [
            'plug_ad_adtypeid' => 1,  //首页顶部banner位置
            'plug_ad_open' => 1
        ];

        return $this->where($where)
            ->order('plug_ad_order aes')
            ->limit(3)
            ->select();
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * app中间banner
     */
    public function getMiddleBanner()
    {
        $where = [
            'plug_ad_adtypeid' => 2,  //首页中间推广banner
            'plug_ad_open' => 1
        ];
        return $this->where($where)
            ->order('plug_ad_order aes')
            ->limit(3)
            ->select();
    }

    /**
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据条件获取banner图,上面的都可以用这个,但是不想改了.
     */
    public function getBannerListByCondition($where)
    {
        return $this->where($where)
            ->where('plug_ad_open', 'eq', 1)
            ->order('plug_ad_order')
            ->limit(3)
            ->select();
    }
}