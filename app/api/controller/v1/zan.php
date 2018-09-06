<?php

namespace app\api\controller\v1;

use app\api\controller\AuthBase;
use think\Db;
use think\Request;

/**
 * Class zan
 * @package app\api\controller\v1
 * 点赞模块
 */
class zan extends AuthBase
{
    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\Exception
     * 因为点赞和取消点赞需要的参数一致,只是反向操作,所以用一个方法就够了
     *
     */
    public function save(Request $request)
    {
        $input = $request->post();
        $db = Db::name('News');
        if (!$input['news_id'] || !$input['user_id'])
            return \show('0', '信息不完整', '', 200);
        $sqldata = [
            'news_id' => $input['news_id'],
            'user_id' => $input['user_id'],
        ];
        //查出同用户,同文章是否已存在点赞数据
        $zan_db = Db::name('NewsZan');
        //直接删除点赞记录,并且该文章的点赞总数-1
        $count = $zan_db->where($sqldata)->count();
        if ($count > 0) {
            //如果已存在点赞,那么就是取消点赞
            $res = $zan_db->where($sqldata)->delete();
            if ($res) {
                $db->where('n_id', 'eq', $input['news_id'])->setDec('news_zan');
            } else {
                return \show('0', '操作失败', '', 200);
            }
        } else {
            //点赞记录入库
            $res = \model('NewsZan')->allowField(true)->save($sqldata);
            if ($res) {
                $db->where('n_id', 'eq', $input['news_id'])->setInc('news_zan');
            } else {
                return \show('0', '操作失败', '', 200);
            }
        }
        //返回点赞总数给app
        $news_zans = $db->where('n_id', 'eq', $input['news_id'])->value('news_zan');
        return \show('1', '操作成功', $news_zans, 200);
    }
}
