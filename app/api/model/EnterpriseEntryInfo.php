<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/28
 * Time: 16:27
 */

namespace app\api\model;


use think\Model;

/**
 * Class EnterpriseEntryInfo
 * @package app\api\model
 */
class EnterpriseEntryInfo extends Model
{
//    返回拼接好的公司地址
    public function getRoomAttr($room)
    {
        $address = '淮安市通源路9号海创空间大厦' . $room . '室';
        return $address;
    }
}