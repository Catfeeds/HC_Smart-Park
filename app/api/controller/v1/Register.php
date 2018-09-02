<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/2
 * Time: 20:47
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

class Register extends Common
{
    public function create(){
        if (!\request()->isPost()){
            return \show(0, '提交方式不正确',403);
        }
        //todo 注册逻辑
    }
}