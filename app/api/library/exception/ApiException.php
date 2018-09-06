<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/1
 * Time: 17:34
 */

namespace app\api\library\exception;


use think\Exception;

/**
 * Class ApiException
 * @package app\api\library\exception
 * 返回api报错信息
 */
class ApiException extends Exception
{
    /**
     * @var string
     */
    public $message = '';
    /**
     * @var int
     */
    public $httpCode = 500;
    /**
     * @var int
     */
    public $code = 0;

    /**
     * @param string $message
     * @param int $httpCode
     * @param int $code
     */
    public function __construct($message = '', $httpCode = 0, $code = 0)
    {
        $this->httpCode = $httpCode;
        $this->message = $message;
        $this->code = $code;
    }
}