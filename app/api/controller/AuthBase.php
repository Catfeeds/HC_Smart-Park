<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 15:39
 */

namespace app\api\controller;

use app\api\library\Aes;
use app\api\library\exception\ApiException;
use think\cache\driver\Redis;

class AuthBase extends Common
{
    /**
     *初始化
     */
    public function _initialize()
    {
        parent::_initialize();
        //debug模式下不检测token
        if (!\config('app_debug'))
            $this->isLogin();
    }

    /**
     *检测token
     */
    protected function isLogin()
    {
        if (empty($this->headers['token'])) {
            return false;
        } else {
            $token = Aes::decrypt(\input('token'));     //解密token
            $redis = new Redis();
            $res = $redis->has($token); //检查token是否存在或过期
            if (!$res)
                new ApiException('请先登录');
        }
    }
}