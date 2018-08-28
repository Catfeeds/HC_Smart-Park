<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 21:53
 */

namespace app\api\controller;


class Test extends Base
{
    public function index()
    {
        return [
            'status=>1',
            'msg' => 'OK',
            'data' => '2018年8月28日 22:03:19'
        ];
    }

    public function update($id = 0)
    {
        return $id;
    }
}