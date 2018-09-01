<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 14:30
 */

namespace app\api\controller\v1;


use app\api\library\exception\ApiException;
use think\Db;
use app\api\controller\Common;

class News extends Common
{
    public function index()
    {
        $list = Db::name('News')->where('news_open', 'eq', 1)->limit('10')->select();
        return \show('200', 'OK', $list);
    }

    public function read()
    {
        $id = input('param.id', 0, 'intval');

        $news= \model('News')->getNewsDetailById($id);
        if (empty($news)){
            return new ApiException('error',404);
        }

    }
}