<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:37
 */

namespace app\admin\controller;


/**
 * Class Webmsg
 * @package app\admin\controller
 * 站内信控制器
 */
class Webmsg extends Base
{
    /**
     *发送站内信操作
     */
    public function sendmsg()
    {
        $toid = "";
        $fromid = "";
        $msg = "";
        $sqldata = [
            'toid' => $toid,
            'fromid' => $fromid,
            'content' => $msg,
            'sendtime' => \time()
        ];

        $res = \db('WebMsg')->insert($sqldata);
        if ($res) {
            $this->success('发送成功！');
        } else {
            $this->error('发送失败！');
        }
    }
}