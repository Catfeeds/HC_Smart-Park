<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/3
 * Time: 9:57
 */

namespace app\api\model;


use think\Model;
use think\Request;

/**
 * Class Admin
 * @package app\api\model
 */
class Admin extends Model
{
    /**
     * @var array
     */
    protected $visible = [
        'admin_avatar'
    ];

    /**
     * @param $admin_avatar
     * @return string
     * 返回拼接好的头像路径
     */
    public function getAdminAvatarAttr($admin_avatar)
    {
        if (!empty($admin_avatar)) {
            return \get_app_imgurl($admin_avatar);
        } else {
            return '';
        }
    }
}