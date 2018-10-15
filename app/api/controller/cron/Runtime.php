<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/15
 * Time: 13:50
 */

namespace app\api\controller\cron;


use app\api\controller\Common;

class Runtime extends Common
{
    public function index(){
        $res = \remove_dir(RUNTIME_PATH);
        return \show(1, 'OK',$res,200);
    }
}