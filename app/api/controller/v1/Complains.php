<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/10
 * Time: 9:57
 */

namespace app\api\controller\v1;


use app\api\controller\AuthBase;

/**
 * Class Complains
 * @package app\api\controller\v1
 * 投诉建议
 */
class Complains extends AuthBase
{
    /**
     * @return \think\response\Json
     * 我的投诉建议列表
     */
    public function index()
    {
        $user_id = \input('user_id');
        $page = \input('page', 1);
        $list = \model('ServiceComplains')->getMyComplainsList($user_id, $page);
        return \show(1, 'OK', $list, 200);
    }


    /**
     * @return \think\response\Json
     * @throws \Exception
     * 发布投诉建议
     */
    public function save()
    {
//        \halt(\input());
        $base64img = \input('image');
        if (!empty($base64img)) {
            $base64img = \json_decode($base64img);
            $pic_url = $this->img_upload($base64img);
            $pic_url = \serialize($pic_url);
        } else {
            $pic_url = '';
        }
        $sqldata = [
            'type' => \input('type'),
            'user_id' => \input('user_id'),
            'phone' => \input('phone'),
            'title' => \input('title'),
            'content' => \input('content'),
            'pic_url' => $pic_url,
        ];
        $res = \model('ServiceComplains')->allowField(true)->save($sqldata);
        if ($res) {
            return \show('1', 'OK', $res, 200);
        } else {
            return \show(0, 'Fail', '', 200);
        }
    }
}