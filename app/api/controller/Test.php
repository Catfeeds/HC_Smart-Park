<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 21:53
 */

namespace app\api\controller;


use app\api\library\ApiException;

class Test extends Common
{
    public function index()
    {

        return \show('1', 'OK');
    }

    public function update($id = 0)
    {
        return $id;
    }
}