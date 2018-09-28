<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/3
 * Time: 16:11
 */

namespace app\api\model;


use think\Model;

/**
 * Class EnterpriseList
 * @package app\api\model
 */
class EnterpriseList extends Model
{
    /**
     * @var array
     * 显示字段
     */
    protected $visible = [
        'id',
        'enterprise_list_name',
        'enterprise_list_logo',
        'enterprise_list_addtime',
        'entry_info.room'
    ];

    /**
     * @return \think\model\relation\HasOne
     * 关联入驻信息
     */
    function EntryInfo()
    {
        return $this
            ->hasOne('EnterpriseEntryInfo', 'enterprise_id', 'id')
            ->setEagerlyType(1);
    }

    /**
     * @param $enterprise_list_addtime
     * @return false|string
     * 时间读取器
     */
    public function getEnterpriseListAddtimeAttr($enterprise_list_addtime)
    {
        return \date('Y-m-d', $enterprise_list_addtime);
    }

    /**
     * @param $enterprise_list_logo
     * @return string
     * 返回拼接好打企业logo地址
     */
    public function getEnterpriseListLogoAttr($enterprise_list_logo)
    {
        if (!empty($enterprise_list_logo)) {
            return \request()->domain() . $enterprise_list_logo;
        } else {
            return '';
        }
    }

    /**
     * @param $page
     * @param $key
     * @return false|\PDOStatement|string|\think\Collection|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 企业列表带搜索
     */
    public function getEnterpriseList($page, $key = '')
    {
        $where = [
            'enterprise_list_name' => ['like', '%' . $key . '%'],
            'enterprise_list_open' => 1,
            'is_delete' => 0
        ];
        return $this
            ::with('EntryInfo')
            ->where($where)
            ->order('enterprise_list_addtime')
            ->page($page, '10')
            ->select();
        return \show('200', 'OK', $list);
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据企业ID获取详情
     */
    public function getEnterpriseDetailById($id)
    {
        return $this
            ::with('EntryInfo')
            ->where('id', 'eq', $id)
            ->find();
    }
}