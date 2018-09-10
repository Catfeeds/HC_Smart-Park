<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/6
 * Time: 23:00
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;

/**
 * Class Upload
 * @package app\api\controller\v1
 * 图片上传控制器
 */
class Upload extends AuthBase
{

    /**
     * @return \think\response\Json
     * @throws \Exception
     * 单图/多图上传图片至本地或者七牛
     */
    public function save()
    {
        $files = \input('image/a');
        $file = \arrToOne($files);
        foreach ($file as $img) {
            $upload = new \app\api\controller\Upload();
            if (\config('storage.storage_open')){
                $res[] = $upload->qiniu_upload($img);
            }else{
                $res[] = $upload->local_upload($img);
            }
        }
        return \show('1', 'OK', $res, 200);
    }
}