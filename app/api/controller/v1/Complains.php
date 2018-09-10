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
     * 发布投诉建议
     */
    public function save()
    {
        $data = \input();
        $sqldata = [
            'type' => $data['type'],
            'user_id' => \input('user_id'),
            'phone' => $data['phone'],
            'title' => $data['title'],
            'content' => $data['content'],
            'pic_url' => \input('pic_url', ''),
        ];
        $res = \model('ServiceComplains')->allowField(true)->save($sqldata);
        if ($res) {
            return \show('1', 'OK', '', 200);
        } else {
            return \show(0, 'Fail', '', 200);
        }
    }
}