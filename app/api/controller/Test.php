<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/28
 * Time: 21:53
 */

namespace app\api\controller;


use app\api\library\ApiException;

class Test extends Common
{
    public function index()
    {
        $banner = [
            '1'=>'a',
            '2'=>'b'
        ];
        $article_list=[
            '3'=>'c',
            '4'=>'d'
        ];
        $data['banner'] = $banner;
        $data['article_lsit'] = $article_list;
        return \show('1', 'OK', $data,200);
    }

    public function update($id = 0)
    {
        return $id;
    }
}