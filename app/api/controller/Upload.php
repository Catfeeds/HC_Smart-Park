<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 17:22
 */

namespace app\api\controller;

use app\api\library\exception\ApiException;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use think\Request;
use think\Db;

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
    function local_upload($base64_image)
    {
        $reqeust = Request::instance();
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
            //文件后缀
            $img_type = $result['2'];
            //文件大小
            $img_size = \strlen($base64_image);
            //检测文件类型
            if (!\in_array($img_type, \config('upload_validate.ext')))
                return new ApiException('文件类型不对', 200, 0);
            //检测文件大小
            if ($img_size / 1024 > \config('upload_validate.size'))
                return new ApiException('文件尺寸太大', 200, 0);
            $image_name = uniqid() . '.' . $img_type;     //文件名
            $path = ROOT_PATH . \config('upload_path') . '/' . date('Y-m-d') . '/';     //上传路径
            //如果不存在文件夹,就创建
            if (!\file_exists($path))
                \mkdir($path);
            //生成最终的图片完整数据
            $image_file = $path . $image_name;
            //保存图片
            if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))) {

                //写入数据库
                $sqldata = [
                    'uptime' => \time(),
                    'filesize' => $img_size,
                    'path' => \config('upload_path') . '/' . date('Y-m-d') . '/' . $image_name
                ];
                Db::name('plug_files')->insert($sqldata);
                //拼接前端可以直接用的图片URL地址
                $img_url = $reqeust->domain() . \config('upload_path') . '/' . date('Y-m-d') . '/' . $image_name;
                return $img_url;
            } else {
                return new ApiException('上传失败',202);
            }
        } else {
            return new ApiException('上传失败',202);
        }
    }


    /**
     * @param $base64
     * @return ApiException|string
     * @throws \Exception
     * base64上传至七牛云
     */
    function qiniu_upload($base64)
    {
        //从配置文件读取七牛配置
        $qiniu_config = \config('storage');
        $auth = new Auth($qiniu_config['accesskey'], $qiniu_config['secretkey']);
        //获取上传所需的token
        $upToken = $auth->uploadToken($qiniu_config['bucket'], null, 3600);
        $uploadMgr = new UploadManager();
        $rand = rand(1111, 9999);
        $now = time();
        $img_type = getimgsuffix($base64);
        $key = \md5($rand . $now) . '.'.$img_type;
        list($ret, $err) = $uploadMgr->putFile($upToken, $key, $base64);
        if ($ret) {
            return \config('storage.domain') . $ret['key'];
        } else {
            return new ApiException($err);
        }
    }
}