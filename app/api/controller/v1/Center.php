<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 11:33
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;
use app\api\controller\Upload;
use think\cache\driver\Redis;

/**
 * Class Center
 * @package app\api\controller\v1
 * 个人中心
 */
class Center extends AuthBase
{

    /**
     * @return bool|string
     * 图片上传接口
     */
    public function imgUpload()
    {
        $img = \input('file/s');
        $upload = new Upload();
        $res = $upload->base64_upload($img);
        return $res;
    }
    /**
     *投诉建议
     */
    public function complains()
    {
        $redis = new Redis();
        $redis->set('token', 'xpwsgg');
        $a = $redis->get('token');
        \halt($a);
        exit;
        $data = \input();
        $sqldata = [
            'type' => $data['type'],
            'user_id' => \getUserIdByPhone($data['phone']),
            'phone' => $data['phone'],
            'title' => $data['title'],
            'content' => $data['content'],
            'pic_url' => \input('pic_url',''),
        ];
        $res = \model('ServiceComplains')->allowField(true)->save($sqldata);
        if ($res) {
            return \show('1', 'OK', '', 200);
        } else {
            return \show(0, 'Fail', '', 200);
        }
    }
}