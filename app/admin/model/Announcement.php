<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/30
 * Time: 9:43
 */

namespace app\admin\model;


use think\Model;

class Announcement extends Model
{
    public function publisher(){
        return $this->belongsTo('Admin','admin_id');
    }
}