<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/6
 * Time: 23:00
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;

class Upload extends AuthBase
{
    /**
     * @return bool|string
     * 单/多图片上传接口
     */
    public function save()
    {
        $files = \input('image/a');
        $file = \arrToOne($files);
        foreach ($file as $img) {
            $upload = new \app\api\controller\Upload();
            $res[] = $upload->base64_upload($img);
        }
        return \show('1', 'OK', $res, 200);
    }
}