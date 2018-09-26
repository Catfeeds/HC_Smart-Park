<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/26
 * Time: 16:47
 */

namespace app\api\controller\v1;


use app\api\controller\Common;

class Search extends Common
{
    public function search()
    {
        //1=社区,2=房源,3=活动
        $type = \input('type');
        //搜索关键字
        $key = \trim(\input('key'));
        switch ($type) {
            case 1:
                $map = [
                    'news_columnid' => 4,
                    'news_back' => 0,
                    'news_open' => 1,
                    'news_title' => ['like', '%' . $key . '%']
                ];
                $list = \model('News')->where($map)->select();
                break;
            case 2:
                $map = [
                    'room_number' => $key
                ];
                $list = \model('ParkRoom')->where($map)->select();
                break;
            case 3:
                $map = [
                    'news_columnid' => 3,
                    'news_back' => 0,
                    'news_open' => 1,
                    'news_title' => ['like', '%' . $key . '%']
                ];
                $list = \model('News')->where($map)->select();
        }
        return \show(1, 'OK', $list, 200);
    }
}