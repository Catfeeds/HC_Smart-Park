<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 20:36
 */

namespace app\api\library;

use think\exception\Handle;
use think\exception\HttpException;
use think\exception\ValidateException;

/**
 * 自定义API模块的错误显示
 */
class ExceptionHandle extends Handle
{

    public function render(\Exception $e)
    {
        // 在生产环境下返回code信息
        if (\config('app_debug') == false)
        {
            $statuscode = $code = 500;
            $msg = 'An error occurred';
            // 验证异常
            if ($e instanceof ValidateException)
            {
                $code = 0;
                $statuscode = 200;
                $msg = $e->getError();
            }
            // Http异常
            if ($e instanceof HttpException)
            {
                $statuscode = $code = $e->getStatusCode();
            }
            return json(['code' => $code, 'msg' => $msg, 'time' => time(), 'data' => null], $statuscode);
        }

        //其它此交由系统处理
        return parent::render($e);
    }

}
