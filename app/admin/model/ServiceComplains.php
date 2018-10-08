<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/25
 * Time: 16:23
 */

namespace app\admin\model;


use think\Model;

class ServiceComplains extends Model
{
    /**
     * @param $pic_url
     * @return mixed|string
     * 返回图片数组
     */
    public function getPicUrlAttr($pic_url)
    {
        if (!empty($pic_url)) {
            return $pic_url = \unserialize($pic_url);
        } else {
            return '';
        }
    }
}