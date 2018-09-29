<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:28
 */

namespace app\api\controller;

use think\Controller;

/**
 * Class Common
 * @package app\api\controller
 * api模块公共控制器
 */
class Common extends Controller
{
    /**
     * @var string
     * 数据头信息
     */
    public $headers = '';

    /**
     *初始化方法
     */
    public function _initialize()
    {
        //debug模式下不检测sign
        if (!\config('app_debug')){
            $this->checkAuth();
        }
    }

    /**
     *检查每次app请求的数据是否合法
     * 1,有没有sign
     * 2,sign值对不对
     * 3,sign是否过期
     */
    public function checkAuth()
    {
        //获取header信息
        $headers = \request()->header();

        //sign参数校验
        if (empty($headers['sign'])) {
            $this->error('sign缺失', 401);
        } elseif (!$this->checkSign()) {
            $this->error('sign错误', 401);
        } elseif (\time() - $headers['time'] > \config('app_sign_time')) {
            $this->error('sign过期', 401);
        } else {
            $this->headers = $headers;
        }
    }

    /**
     * @return bool
     * 检测sign方法
     */
    function checkSign()
    {
        //获取header信息
        $headers = \request()->header();
        //和前端使用同样的数据和加密方式验证sign是否一致
        $sign = md5('xpwsgg');  //后台进行sign加密运算
        if ($sign === $headers['sign']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     * 检查版本号
     */
    function checkVersion()
    {
        $version_info = \config('app_version');
        $headers = \request()->header();
        if ($version_info['publish_time'] > $headers['publish_time']) {
            return \show(1, '有更新哟!', $version_info, 200);
        }else{
            return \show(0, '已是最新版本','',200);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \Exception
     * 公共的图片上传接口
     */
    function img_upload($files)
    {
        $file = \arrToOne($files);
        foreach ($file as $img) {
            $upload = new \app\api\controller\Upload();
            if (\config('storage.storage_open')) {
                $res[] = $upload->qiniu_upload($img);
            } else {
                $res[] = $upload->local_upload($img);
            }
        }
        return $res;
    }
}