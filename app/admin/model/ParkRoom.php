<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/12
 * Time: 11:12
 */

namespace app\admin\model;


use think\Model;
use think\Request;

class ParkRoom extends Model
{
    /**
     * @var array
     */

    protected $visible = [
        'floor',
        'room_number',
        'area',
        'status'

    ];


    /**
     * @param $room_img
     * @return string
     * 返回拼接好的图片路径
     */

    public function getRoomImgAttr($room_img)

    {
        if (!empty($room_img)) {
            $request = Request::instance();
            return $request->domain() . $room_img;
        } else {
            return '';
        }
    }


    /**
     * @param $value
     * @return mixed
     */

    public function getPhaseAttr($value)

    {
        $status = [1 => '海创空间大厦一期', 2 => '海创空间大厦二期'];
        return $status[$value];
    }


    /**
     * @param $room_pic_allurl
     * @return array
     * 返回拼接好的多图路径
     */

    public function getRoomPicAllurlAttr($room_pic_allurl)
    {
        $request = Request::instance();
        $arr = \explode(',', $room_pic_allurl);

        foreach ($arr as &$v) {
            if (!empty($v)) {
                $v = $request->domain() . $v;
            }
        }
        return array_filter($arr);
    }
}