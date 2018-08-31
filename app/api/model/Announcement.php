<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/31
 * Time: 23:09
 */

namespace app\api\model;


use think\Model;

class Announcement extends Model
{
    public function getAnnouncement()
    {
        return $this
            ->limit('5')
            ->select();
    }
}