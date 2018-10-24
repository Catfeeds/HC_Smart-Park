<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/24
 * Time: 9:50
 */

namespace app\api\model;


use think\Model;

class ParkBuilding extends Model
{
    protected $hidden = [
        'order',
        'create_time'
    ];

    public function getStatusAttr($status)
    {
        switch ($status) {
            case 1:
                return '启用';
                break;
            case 0:
                return '禁用';
                break;
            default:
                return '未知状态';
        }
    }
}