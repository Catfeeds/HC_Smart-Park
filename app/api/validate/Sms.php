<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/3
 * Time: 14:23
 */

namespace app\api\validate;

use think\Validate;

class Sms extends Validate
{
    protected $rule = [
        'phone' => 'require|mobile',
    ];
}