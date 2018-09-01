<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/1
 * Time: 17:46
 */

namespace app\api\library\exception;

use think\exception\Handle;

/**
 * Class ApiHandleException
 * @package app\api\library\exception
 * Api异常处理
 */
class ApiHandleException extends Handle
{
    /**
     * http 状态码
     * @var int
     */
    public $httpCode = 500;

    public function render(\Exception $e)
    {

        if (config('app_debug') == true) {
            return parent::render($e);
        }
        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }
        return show(0, $e->getMessage(), [], $this->httpCode);
    }
}