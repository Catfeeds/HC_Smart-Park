<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 22:46
 */

namespace app\api\model;


use think\Model;

class PlugAd extends Model
{
    public function getHeadBanner(){
        $where = [
            'plug_ad_adtypeid'=>1,  //首页顶部banner位置
            'plug_ad_open'=>1
        ];

        return $this->where($where)
            ->field('plug_ad_pic,plug_ad_content,plug_ad_url')
            ->order('plug_ad_order aes')
            ->limit(3)
            ->select();
    }

    public function getMiddleBanner(){
        $where = [
            'plug_ad_adtypeid'=>2,  //首页中间推广banner
            'plug_ad_open'=>1
        ];
        return $this->where($where)
            ->field('plug_ad_pic,plug_ad_content,plug_ad_url')
            ->order('plug_ad_order aes')
            ->limit(3)
            ->select();
    }
}