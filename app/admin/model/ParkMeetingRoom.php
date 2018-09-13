<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/13
 * Time: 11:55
 */

namespace app\admin\model;


use think\Model;

class ParkMeetingRoom extends Model
{
    protected function getEquipmentAttr($equipment){
        return \unserialize($equipment);
    }
}