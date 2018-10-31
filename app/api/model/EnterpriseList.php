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
    protected $hidden = [
        'enterprise_list_open',
        'is_delete',

        'bank_info.id',
        'bank_info.enterprise_id',

        'enterprise_business.id',
        'enterprise_business.enterprise_id',

        'enterprise_contact.id',
        'enterprise_contact.enterprise_id',

        'entry_info.id',
        'entry_info.enterprise_id',
    ];

    /**
     * @return \think\model\relation\HasOne
     * 关联银行信息
     */
    function BankInfo()
    {
        return $this->hasOne('EnterpriseBank', 'enterprise_id', 'id')
            ->setEagerlyType(1);
    }

    /**
     * @return \think\model\relation\HasOne
     *关联业务信息
     */
    function EnterpriseBusiness()
    {
        return $this->hasOne('EnterpriseBusiness', 'enterprise_id', 'id')
            ->setEagerlyType(1);
    }

    /**
     * @return \think\model\relation\HasOne
     * 关联联系方式
     */
    function EnterpriseContact()
    {
        return $this->hasOne('EnterpriseContact', 'enterprise_id', 'id')
            ->setEagerlyType(1);
    }

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
     * @param $time
     * @return false|string
     * 返回格式化的成立日期
     */
    public function getEnterpriseListLegalSetupDayAttr($time)
    {
        if ($time > 0) {
            return \date('Y-m-d', $time);
        } else {
            return '信息未填写';
        }
    }

    /**
     * @param $enterprise_list_logo
     * @return string
     * 返回拼接好打企业logo地址
     */
    public function getEnterpriseListLogoAttr($enterprise_list_logo)
    {
        if (!empty($enterprise_list_logo)) {
            return \get_app_imgurl($enterprise_list_logo);
        } else {
            return '';
        }
    }

    /**
     * @param $pic
     * @return string
     * 返回拼接好打企业营业执照地址
     */
    public function getEnterpriseListLicenseImgAttr($pic)
    {
        if (!empty($pic)) {
            return \get_app_imgurl($pic);
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
            ::with('BankInfo,EnterpriseBusiness,EnterpriseContact,EntryInfo')
            ->where('id', 'eq', $id)
            ->find();
    }
}