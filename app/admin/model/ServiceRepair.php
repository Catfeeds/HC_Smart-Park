<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/11
 * Time: 10:57
 */

namespace app\admin\model;


use think\Db;
use think\Model;

/**
 * Class ServiceRepair
 * @package app\api\model
 * 报修模块
 */
class ServiceRepair extends Model
{
    /**
     * @var bool
     * 时间戳自动写入
     */
    protected $autoWriteTimestamp = true;

    /**
     * @param $value
     * @return mixed
     * 返回中文状态
     */
    public function getStatusAttr($value)
    {
        $status = [0 => '未处理', 1 => '处理中', 2 => '已处理', 3 => '催办', 4 => '已撤回'];
        return $status[$value];
    }

    /**
     * @param $create_time
     * @return false|string
     * 返回格式化时间
     */
    public function getCreateTimeAttr($create_time)
    {
        return \date('Y-m-d H:i:s', $create_time);
    }

    /**
     * @param $handler_time
     * @return false|string
     * 返回格式化时间
     */
    public function getHandlerTimeAttr($handler_time)
    {
        if (!empty($handler_time)) {
            return \date('Y-m-d H:i:s', $handler_time);
        } else {
            return '';
        }
    }

    /**
     * @param $handler_id
     * @return mixed|string
     * 返回处理人姓名
     */
    public function getHandlerIdAttr($handler_id)
    {
        if (!empty($handler_id)) {
            return Db::name('Admin')->where('admin_id', 'eq', $handler_id)->value('admin_username');
        } else {
            return '待处理';
        }
    }

    /**
     * @param $pic_url
     * @return mixed|string
     * 返回图片数组
     */
    public function getPicUrlAttr($pic_url)
    {
        if (!empty($pic_url)) {
            return $pic_url = \unserialize($pic_url);
        } else {
            return '';
        }
    }
}