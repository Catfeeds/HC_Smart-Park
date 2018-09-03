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
     * @param $plug_ad_pic
     * @return string
     * 返回完整的图片路径,不需要客户端再拼接
     */
    protected function getPlugAdPicAttr($plug_ad_pic)
    {
        $reqeust = Request::instance();
        return $reqeust->domain() . $plug_ad_pic;
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
            ->field('plug_ad_pic,plug_ad_content,plug_ad_url')
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
            ->field('plug_ad_pic,plug_ad_content,plug_ad_url')
            ->order('plug_ad_order aes')
            ->limit(3)
            ->select();
    }
}