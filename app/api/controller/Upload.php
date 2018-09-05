<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 17:22
 */

namespace app\api\controller;

use app\api\library\exception\ApiException;
use think\Request;

/**
 * Class Upload
 * @package app\api\controller
 * api图片上传类
 */
class Upload extends AuthBase
{
    /**
     * @param $base64
     * @return bool|string
     * bash64上传图片
     * @param $base64 图片的base64数据
     */
    function base64_upload($base64_image)
    {
        $reqeust = Request::instance();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
            $img_type = $result['2'];       //文件后缀
            //检测文件类型
            if (!\in_array($img_type, \config('upload_validate.ext')))
                return new ApiException('文件类型不对', 200, 0);
            if (\strlen($base64_image) / 1024 > \config('upload_validate.size'))
                return new ApiException('文件尺寸太大', 200, 0);
            $image_name = uniqid() . '.' . $img_type;     //文件名
            $path = ROOT_PATH . \config('upload_path') . '/' . date('Y-m-d') . '/';     //上传路径
            $image_file = $path . $image_name;

            //保存图片
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))) {
                //拼接前端可以直接用的图片URL地址
                $img_url = $reqeust->domain() . \config('upload_path') . '/' . date('Y-m-d') . '/' . $image_name;
                return \show('1', 'OK', $img_url, 200);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}