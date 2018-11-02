<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/18
 * Time: 10:57
 */

namespace app\api\controller\charts;


use app\api\model\ParkRoom;
use app\common\controller\Common;
use think\Db;

/**
 * Class Index
 * @package app\api\controller\charts
 * 首页图表接口
 */
class Index extends Common
{
    /**
     * @return mixed
     * 首页房源饼状图数据
     */
    public function room_status()
    {
        $model = new ParkRoom();
        $status0 = $model->where('status', 0)->count();
        $data[0] = ['value' => $status0, 'name' => '未租'];

        $status1 = $model->where('status', 1)->count();
        $data[1] = ['value' => $status1, 'name' => '已租'];

        $status2 = $model->where('status', 2)->count();
        $data[2] = ['value' => $status2, 'name' => '已售'];

        $status3 = $model->where('status', 3)->count();
        $data[3] = ['value' => $status3, 'name' => '已订'];

        $status4 = $model->where('status', 4)->count();
        $data[4] = ['value' => $status4, 'name' => '自留'];
        return $data;
    }


    /**
     * @return array
     * 每月出租房源趋势图
     */
    public function room_month_status()
    {

        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('ParkRoom')
                ->where('entry_time', 'between time', [$m_s, $m_e])
                ->where('status', 'eq', 1)
                ->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     *每月企业入驻数据
     */
    public function enterprise_entry_month()
    {
        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('EnterpriseList')->where('enterprise_list_addtime', 'between time', [$m_s, $m_e])->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     * 每个月注册用户数量
     */
    public function user_month()
    {
        for ($i = 1; $i < 13; $i++) {
            //每个月开始时间
            $m_s = \date('Y' . '-' . $i . '-' . '01');
            //每个月结束时间
            $m_e = \date('Y' . '-' . $i . '-' . 't');
            $data[] = Db::name('MemberList')->where('member_list_addtime', 'between time', [$m_s, $m_e])->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array
     * 海创二七大楼每层入驻情况(5~21层)
     */
    public function one_floor_entry()
    {
        for ($i = 1; $i < 24; $i++) {
            $data[] = Db::name('ParkRoom')
                ->where('phase', 'eq', 2)//默认为海创二期大楼
                ->where('floor', 'eq', $i)
                ->where('status', 'eq', 1)
                ->count();
        }
        return ['data' => $data];
    }

    /**
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 二期大楼每层的入驻情况
     */
    public function build_floor()
    {
        $floor = \input('floor', 1);
        switch ($floor) {
            case ($floor == 1):
                $data[0] = [
                    'floor' => '1',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '人才市场',
                    'room_number' => 101,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="组_22" data-name="组 22" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1662 725">
<defs>
    <style>
      .cls-1, .cls-2 {
        fill: #585b7a;
      }

      .cls-2, .cls-3 {
        fill-rule: evenodd;
      }

      .cls-3 {
        fill: #eef4f9;
      }
    </style>
  </defs>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="625" y="227" width="108" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="593" y="140" width="44" height="4"/>
  <rect id="矩形_3_拷贝_75" data-name="矩形 3 拷贝 75" class="cls-1" x="593" y="170" width="44" height="4"/>
  <rect id="矩形_3_拷贝_74" data-name="矩形 3 拷贝 74" class="cls-1" x="593" y="105" width="44" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="593" y="132" width="4" height="24"/>
  <rect id="矩形_4_拷贝_17" data-name="矩形 4 拷贝 17" class="cls-1" x="822" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_18" data-name="矩形 4 拷贝 18" class="cls-1" x="684" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_19" data-name="矩形 4 拷贝 19" class="cls-1" x="966" y="263" width="14" height="14"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="593" y="106" width="4" height="16"/>
  <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="88" y="611" width="611" height="6"/>
  <rect id="矩形_1_拷贝" data-name="矩形 1 拷贝" class="cls-1" x="968" y="611" width="611" height="6"/>
  <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1575" y="186" width="6" height="429"/>
  <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="87" y="194" width="6" height="423"/>
  <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="387" y="93" width="451" height="6"/>
  <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="101" y="181" width="153" height="6"/>
  <rect id="矩形_3_拷贝_28" data-name="矩形 3 拷贝 28" class="cls-1" x="275" y="181" width="32" height="6"/>
  <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="92" y="261" width="276" height="4"/>
  <rect id="矩形_3_拷贝_27" data-name="矩形 3 拷贝 27" class="cls-1" x="391" y="261" width="307" height="4"/>
  <rect id="矩形_3_拷贝_15" data-name="矩形 3 拷贝 15" class="cls-1" x="303" y="227" width="116" height="4"/>
  <rect id="矩形_3_拷贝_17" data-name="矩形 3 拷贝 17" class="cls-1" x="303" y="184" width="4" height="47"/>
  <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="136" y="204" width="4" height="47"/>
  <rect id="矩形_3_拷贝_24" data-name="矩形 3 拷贝 24" class="cls-1" x="168" y="183" width="4" height="32"/>
  <rect id="矩形_3_拷贝_25" data-name="矩形 3 拷贝 25" class="cls-1" x="168" y="239" width="4" height="26"/>
  <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="91" y="224" width="47" height="2"/>
  <rect id="矩形_3_拷贝_16" data-name="矩形 3 拷贝 16" class="cls-1" x="438" y="227" width="135" height="4"/>
  <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="587" y="227" width="18" height="4"/>
  <rect id="矩形_3_拷贝_26" data-name="矩形 3 拷贝 26" class="cls-1" x="632" y="216" width="4" height="15"/>
  <rect id="矩形_3_拷贝_30" data-name="矩形 3 拷贝 30" class="cls-1" x="518" y="254" width="4" height="11"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="518" y="227" width="4" height="11"/>
  <rect id="矩形_3_拷贝_19" data-name="矩形 3 拷贝 19" class="cls-1" x="563" y="96" width="4" height="97"/>
  <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="438" y="96" width="4" height="102"/>
  <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="301" y="103" width="6" height="83"/>
  <rect id="矩形_3_拷贝_10" data-name="矩形 3 拷贝 10" class="cls-1" x="304" y="103" width="83" height="6"/>
  <rect id="矩形_3_拷贝_12" data-name="矩形 3 拷贝 12" class="cls-1" x="381" y="93" width="6" height="16"/>
  <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="966" y="93" width="315" height="6"/>
  <rect id="矩形_3_拷贝_13-2" data-name="矩形 3 拷贝 13" class="cls-1" x="1415" y="181" width="152" height="6"/>
  <rect id="矩形_3_拷贝_29" data-name="矩形 3 拷贝 29" class="cls-1" x="1366" y="181" width="25" height="6"/>
  <rect id="矩形_3_拷贝_13-3" data-name="矩形 3 拷贝 13" class="cls-1" x="1361" y="103" width="6" height="129"/>
  <rect id="矩形_3_拷贝_13-4" data-name="矩形 3 拷贝 13" class="cls-1" x="1281" y="103" width="83" height="6"/>
  <rect id="矩形_3_拷贝_13-5" data-name="矩形 3 拷贝 13" class="cls-1" x="1281" y="93" width="6" height="16"/>
  <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="88" y="603" width="14" height="14"/>
  <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="87" y="181" width="14" height="14"/>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="433" y="97" width="14" height="14"/>
  <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="558" y="97" width="14" height="14"/>
  <rect id="矩形_4_拷贝_9" data-name="矩形 4 拷贝 9" class="cls-1" x="559" y="217" width="14" height="14"/>
  <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="438" y="214" width="14" height="14"/>
  <rect id="矩形_4" data-name="矩形 4" class="cls-1" x="1567" y="256" width="14" height="14"/>
  <rect id="矩形_4_拷贝_10" data-name="矩形 4 拷贝 10" class="cls-1" x="1221" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="1567" y="181" width="14" height="14"/>
  <rect id="矩形_4_拷贝-2" data-name="矩形 4 拷贝" class="cls-1" x="1566" y="376" width="14" height="14"/>
  <rect id="矩形_4_拷贝_2" data-name="矩形 4 拷贝 2" class="cls-1" x="1342" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13" data-name="矩形 4 拷贝 13" class="cls-1" x="1223" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13-2" data-name="矩形 4 拷贝 13" class="cls-1" x="1344" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="1093" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11-2" data-name="矩形 4 拷贝 11" class="cls-1" x="1093" y="370" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="1093" y="483" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12-2" data-name="矩形 4 拷贝 12" class="cls-1" x="1093" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1567" y="603" width="14" height="14"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="966" y="261" width="433" height="4"/>
  <rect id="矩形_3_拷贝_58" data-name="矩形 3 拷贝 58" class="cls-1" x="1097" y="263" width="4" height="120"/>
  <rect id="矩形_3_拷贝_59" data-name="矩形 3 拷贝 59" class="cls-1" x="1098" y="486" width="4" height="120"/>
  <rect id="矩形_4_拷贝_16" data-name="矩形 4 拷贝 16" class="cls-1" x="559" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_16-2" data-name="矩形 4 拷贝 16" class="cls-1" x="558" y="370" width="14" height="14"/>
  <rect id="矩形_4_拷贝_16-3" data-name="矩形 4 拷贝 16" class="cls-1" x="559" y="483" width="14" height="14"/>
  <rect id="矩形_4_拷贝_16-4" data-name="矩形 4 拷贝 16" class="cls-1" x="558" y="597" width="14" height="14"/>
  <rect id="矩形_3_拷贝_60" data-name="矩形 3 拷贝 60" class="cls-1" x="564" y="263" width="4" height="120"/>
  <rect id="矩形_3_拷贝_60-2" data-name="矩形 3 拷贝 60" class="cls-1" x="564" y="486" width="4" height="120"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="1423" y="261" width="156" height="4"/>
  <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="633" y="105" width="100" height="4"/>
  <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="676" y="158" width="50" height="2"/>
  <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="676" y="204" width="50" height="2"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="593" y="164" width="4" height="63"/>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="593" y="181" width="41" height="4"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="676" y="108" width="4" height="119"/>
  <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="105" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="139" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="174" width="4" height="24"/>
  <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="213" width="4" height="18"/>
  <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="171" width="1" height="24"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="633" y="108" width="4" height="85"/>
  <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="725" y="167" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="167" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,166h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,199l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="690" y="171" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="194" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="171" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="166" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="199" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="122" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="725" y="118" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="118" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,117h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,150l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="690" y="122" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="145" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="122" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="117" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="150" width="30" height="1"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="227" width="57" height="4"/>
  <rect id="矩形_3_拷贝_53-2" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="105" width="57" height="4"/>
  <rect id="矩形_3_拷贝_53-3" data-name="矩形 3 拷贝 53" class="cls-1" x="788" y="158" width="50" height="2"/>
  <rect id="矩形_3_拷贝_53-4" data-name="矩形 3 拷贝 53" class="cls-1" x="788" y="204" width="50" height="2"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="834" y="98" width="4" height="129"/>
  <rect id="矩形_3_拷贝_53-5" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="105" width="4" height="20"/>
  <rect id="矩形_3_拷贝_53-6" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="139" width="4" height="20"/>
  <rect id="矩形_3_拷贝_53-7" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="174" width="4" height="24"/>
  <rect id="矩形_3_拷贝_53-8" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="213" width="4" height="18"/>
  <rect id="矩形_5_拷贝_18" data-name="矩形 5 拷贝 18" class="cls-1" x="829" y="171" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-2" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="167" width="1" height="32"/>
  <rect id="矩形_5_拷贝_18-3" data-name="矩形 5 拷贝 18" class="cls-1" x="817" y="167" width="1" height="32"/>
  <path id="矩形_5_拷贝_18-4" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,166h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_18-5" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,199l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_18-6" data-name="矩形 5 拷贝 18" class="cls-1" x="823" y="171" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-7" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="194" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-8" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="171" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-9" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="166" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-10" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="199" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-11" data-name="矩形 5 拷贝 18" class="cls-1" x="829" y="122" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-12" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="118" width="1" height="32"/>
  <rect id="矩形_5_拷贝_18-13" data-name="矩形 5 拷贝 18" class="cls-1" x="817" y="118" width="1" height="32"/>
  <path id="矩形_5_拷贝_18-14" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,117h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_18-15" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,150l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_18-16" data-name="矩形 5 拷贝 18" class="cls-1" x="823" y="122" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-17" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="145" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-18" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="122" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-19" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="117" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-20" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="150" width="30" height="1"/>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="1154" y="228" width="83" height="4"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="1249" y="228" width="83" height="4"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="1346" y="228" width="21" height="4"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1127" y="228" width="18" height="4"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="1098" y="216" width="4" height="12"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="1228" y="255" width="4" height="12"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="1228" y="226" width="4" height="12"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="963" y="227" width="59" height="4"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1048" y="99" width="4" height="132"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1162" y="183" width="52" height="4"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="1185" y="97" width="2" height="88"/>
  <rect id="矩形_3_拷贝_22" data-name="矩形 3 拷贝 22" class="cls-1" x="1228" y="94" width="4" height="134"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1141" y="94" width="4" height="138"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="963" y="93" width="4" height="134"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1098" y="94" width="4" height="109"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="1048" y="227" width="60" height="4"/>
  <rect id="矩形_4-2" data-name="矩形 4" class="cls-1" x="1223" y="214" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="1353" y="214" width="14" height="14"/>
  <rect id="矩形_4_拷贝-3" data-name="矩形 4 拷贝" class="cls-1" x="964" y="109" width="14" height="14"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="964" y="216" width="14" height="14"/>
  <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="105" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="1106" y="146" width="32" height="1"/>
  <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="1106" y="117" width="32" height="1"/>
  <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-2" d="M1105,117v1l34,29v-1Z"/>
  <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-2" d="M1138,117l-33,30h1l33-30h-1Z"/>
  <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="111" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="1133" y="105" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="105" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="1105" y="117" width="1" height="30"/>
  <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="1138" y="117" width="1" height="30"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="140" y="484" width="4" height="92"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="140" y="597" width="4" height="20"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="90" y="484" width="54" height="4"/>
  <rect id="矩形_5_拷贝_22" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="528" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-2" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="532" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-3" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="536" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-4" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="540" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-5" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="544" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-6" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="548" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-7" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="552" width="25" height="1"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="1522" y="484" width="4" height="92"/>
  <rect id="矩形_3_拷贝_50-2" data-name="矩形 3 拷贝 50" class="cls-1" x="1522" y="597" width="4" height="20"/>
  <rect id="矩形_3_拷贝_50-3" data-name="矩形 3 拷贝 50" class="cls-1" x="1522" y="484" width="54" height="4"/>
  <rect id="矩形_5_拷贝_23" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="528" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-2" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="532" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-3" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="536" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-4" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="540" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-5" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="544" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-6" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="548" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-7" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="552" width="25" height="1"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1098" y="155" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1134" y="155" width="11" height="4"/>
  <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="155" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="159" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="179" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="183" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="163" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="167" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="171" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="639" y="175" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="134" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="138" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="125" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="129" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="142" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="146" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="150" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="659" y="154" width="15" height="1"/>
  <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="656" y="119" width="1" height="71"/>
  <rect id="矩形_5_拷贝_30" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="165" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-2" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="169" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-3" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="189" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-4" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="193" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-5" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="173" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-6" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="177" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-7" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="181" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-8" data-name="矩形 5 拷贝 30" class="cls-1" x="1056" y="185" width="18" height="1"/>
  <rect id="矩形_5_拷贝_30-9" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="144" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-10" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="148" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-11" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="135" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-12" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="139" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-13" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="152" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-14" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="156" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-15" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="160" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-16" data-name="矩形 5 拷贝 30" class="cls-1" x="1079" y="164" width="15" height="1"/>
  <rect id="矩形_5_拷贝_30-17" data-name="矩形 5 拷贝 30" class="cls-1" x="1076" y="129" width="1" height="71"/>
  <rect id="矩形_5" data-name="矩形 5" class="cls-1" x="679" y="365" width="29" height="29"/>
  <rect id="矩形_5_拷贝_2" data-name="矩形 5 拷贝 2" class="cls-1" x="954" y="365" width="29" height="29"/>
  <path id="矩形_6" data-name="矩形 6" class="cls-3" d="M702,591H965v29h13v97H688V620h14V591Z"/>
  <path id="矩形_5_拷贝" data-name="矩形 5 拷贝" class="cls-2" d="M899,394H749V362h15v3H899v-3h15v32H899Z"/>
  <path id="矩形_5_拷贝_3" data-name="矩形 5 拷贝 3" class="cls-3" d="M960,104H841V90h-7V79H968V90h-8v14Z"/>
</svg>

EFO;
                return \show(1, 'OK', $data, 200);
                break;
            case ($floor == 2):
                $data[0] = [
                    'floor' => '2',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '人才中心',
                    'room_number' => 201,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="组_17" data-name="组 17" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1662 725">
<defs>
    <style>
      .cls-1, .cls-2 {
        fill: #585b7a;
      }

      .cls-2, .cls-4 {
        fill-rule: evenodd;
      }

      .cls-3, .cls-4 {
        fill: #eef4f9;
      }

      .cls-3 {
        opacity: 0.45;
      }
    </style>
  </defs>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="595" y="170" width="42" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="595" y="139" width="42" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="594" y="132" width="4" height="18"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="594" y="105" width="4" height="10"/>
  <g id="组_19" data-name="组 19">
    <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1098" y="155" width="11" height="4"/>
    <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1134" y="155" width="11" height="4"/>
  </g>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="1154" y="228" width="83" height="4"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="1249" y="228" width="83" height="4"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="1346" y="228" width="21" height="4"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="852" y="227" width="170" height="4"/>
  <g id="组_9" data-name="组 9">
    <g id="组_12" data-name="组 12">
      <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="140" y="484" width="4" height="92"/>
      <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="140" y="597" width="4" height="20"/>
      <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="90" y="484" width="54" height="4"/>
      <rect id="矩形_5_拷贝_22" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="528" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-2" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="532" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-3" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="536" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-4" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="540" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-5" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="544" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-6" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="548" width="25" height="1"/>
      <rect id="矩形_5_拷贝_22-7" data-name="矩形 5 拷贝 22" class="cls-1" x="101" y="552" width="25" height="1"/>
      <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="1522" y="484" width="4" height="92"/>
      <rect id="矩形_3_拷贝_45-2" data-name="矩形 3 拷贝 45" class="cls-1" x="1522" y="597" width="4" height="20"/>
      <rect id="矩形_3_拷贝_45-3" data-name="矩形 3 拷贝 45" class="cls-1" x="1522" y="484" width="54" height="4"/>
      <rect id="矩形_5_拷贝_23" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="528" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-2" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="532" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-3" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="536" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-4" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="540" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-5" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="544" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-6" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="548" width="25" height="1"/>
      <rect id="矩形_5_拷贝_23-7" data-name="矩形 5 拷贝 23" class="cls-1" x="1540" y="552" width="25" height="1"/>
    </g>
  </g>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1162" y="183" width="52" height="4"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="1185" y="97" width="2" height="88"/>
  <rect id="矩形_3_拷贝_22" data-name="矩形 3 拷贝 22" class="cls-1" x="1228" y="94" width="4" height="134"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="963" y="93" width="4" height="134"/>
  <rect id="矩形_4" data-name="矩形 4" class="cls-1" x="1223" y="214" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="1352" y="214" width="14" height="14"/>
  <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="964" y="109" width="14" height="14"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="964" y="216" width="14" height="14"/>
  <g id="组_13" data-name="组 13">
    <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1127" y="228" width="18" height="4"/>
    <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="1098" y="216" width="4" height="12"/>
    <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1048" y="99" width="4" height="132"/>
    <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1141" y="94" width="4" height="138"/>
    <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1098" y="94" width="4" height="109"/>
    <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="1048" y="227" width="60" height="4"/>
    <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="105" width="24" height="1"/>
    <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="1106" y="146" width="32" height="1"/>
    <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="1106" y="117" width="32" height="1"/>
    <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-2" d="M1105,117v1l34,29v-1Z"/>
    <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-2" d="M1138,117l-33,30h1l33-30h-1Z"/>
    <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="111" width="24" height="1"/>
    <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="1133" y="105" width="1" height="6"/>
    <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="1110" y="105" width="1" height="6"/>
    <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="1105" y="117" width="1" height="30"/>
    <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="1138" y="117" width="1" height="30"/>
  </g>
  <rect id="矩形_1_拷贝" data-name="矩形 1 拷贝" class="cls-1" x="968" y="611" width="611" height="6"/>
  <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1575" y="186" width="6" height="429"/>
  <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="87" y="194" width="6" height="423"/>
  <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="387" y="93" width="451" height="6"/>
  <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="101" y="181" width="206" height="6"/>
  <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="92" y="261" width="606" height="4"/>
  <rect id="矩形_3_拷贝_15" data-name="矩形 3 拷贝 15" class="cls-1" x="296" y="227" width="123" height="4"/>
  <rect id="矩形_3_拷贝_17" data-name="矩形 3 拷贝 17" class="cls-1" x="296" y="184" width="4" height="47"/>
  <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="136" y="204" width="4" height="47"/>
  <rect id="矩形_3_拷贝_24" data-name="矩形 3 拷贝 24" class="cls-1" x="168" y="183" width="4" height="32"/>
  <rect id="矩形_3_拷贝_25" data-name="矩形 3 拷贝 25" class="cls-1" x="168" y="239" width="4" height="26"/>
  <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="91" y="224" width="47" height="2"/>
  <rect id="矩形_3_拷贝_16" data-name="矩形 3 拷贝 16" class="cls-1" x="437" y="227" width="136" height="4"/>
  <rect id="矩形_3_拷贝_19" data-name="矩形 3 拷贝 19" class="cls-1" x="563" y="96" width="4" height="97"/>
  <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="437" y="96" width="4" height="135"/>
  <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="301" y="103" width="6" height="83"/>
  <rect id="矩形_3_拷贝_10" data-name="矩形 3 拷贝 10" class="cls-1" x="304" y="103" width="83" height="6"/>
  <rect id="矩形_3_拷贝_12" data-name="矩形 3 拷贝 12" class="cls-1" x="381" y="93" width="6" height="16"/>
  <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="836" y="93" width="445" height="6"/>
  <rect id="矩形_3_拷贝_13-2" data-name="矩形 3 拷贝 13" class="cls-1" x="1361" y="181" width="206" height="6"/>
  <rect id="矩形_3_拷贝_13-3" data-name="矩形 3 拷贝 13" class="cls-1" x="1361" y="103" width="6" height="129"/>
  <rect id="矩形_3_拷贝_13-4" data-name="矩形 3 拷贝 13" class="cls-1" x="1281" y="103" width="83" height="6"/>
  <rect id="矩形_3_拷贝_13-5" data-name="矩形 3 拷贝 13" class="cls-1" x="1281" y="93" width="6" height="16"/>
  <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="88" y="603" width="14" height="14"/>
  <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="87" y="181" width="14" height="14"/>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="432" y="97" width="14" height="14"/>
  <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="558" y="97" width="14" height="14"/>
  <rect id="矩形_4_拷贝_9" data-name="矩形 4 拷贝 9" class="cls-1" x="559" y="217" width="14" height="14"/>
  <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="437" y="214" width="14" height="14"/>
  <rect id="矩形_4-2" data-name="矩形 4" class="cls-1" x="1567" y="256" width="14" height="14"/>
  <rect id="矩形_4_拷贝_10" data-name="矩形 4 拷贝 10" class="cls-1" x="1221" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝-2" data-name="矩形 4 拷贝" class="cls-1" x="1567" y="181" width="14" height="14"/>
  <rect id="矩形_4_拷贝-3" data-name="矩形 4 拷贝" class="cls-1" x="1566" y="376" width="14" height="14"/>
  <rect id="矩形_4_拷贝_2" data-name="矩形 4 拷贝 2" class="cls-1" x="1342" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13" data-name="矩形 4 拷贝 13" class="cls-1" x="1223" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13-2" data-name="矩形 4 拷贝 13" class="cls-1" x="1344" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="1094" y="263" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11-2" data-name="矩形 4 拷贝 11" class="cls-1" x="1094" y="370" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="1094" y="483" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12-2" data-name="矩形 4 拷贝 12" class="cls-1" x="1094" y="597" width="14" height="14"/>
  <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1567" y="603" width="14" height="14"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="966" y="261" width="433" height="4"/>
  <rect id="矩形_3_拷贝_58" data-name="矩形 3 拷贝 58" class="cls-1" x="1099" y="263" width="4" height="120"/>
  <rect id="矩形_3_拷贝_59" data-name="矩形 3 拷贝 59" class="cls-1" x="1099" y="486" width="4" height="120"/>
  <rect id="矩形_4_拷贝_16" data-name="矩形 4 拷贝 16" class="cls-1" x="559" y="263" width="14" height="14"/>
  <g id="组_10" data-name="组 10">
    <rect id="矩形_4_拷贝_17" data-name="矩形 4 拷贝 17" class="cls-1" x="822" y="263" width="14" height="14"/>
    <rect id="矩形_4_拷贝_18" data-name="矩形 4 拷贝 18" class="cls-1" x="684" y="263" width="14" height="14"/>
    <rect id="矩形_4_拷贝_19" data-name="矩形 4 拷贝 19" class="cls-1" x="966" y="263" width="14" height="14"/>
  </g>
  <rect id="矩形_4_拷贝_16-2" data-name="矩形 4 拷贝 16" class="cls-1" x="558" y="370" width="14" height="14"/>
  <rect id="矩形_3_拷贝_60" data-name="矩形 3 拷贝 60" class="cls-1" x="564" y="263" width="4" height="120"/>
  <g id="组_11" data-name="组 11">
    <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="88" y="611" width="881" height="6"/>
    <rect id="矩形_4_拷贝_16-3" data-name="矩形 4 拷贝 16" class="cls-1" x="559" y="483" width="14" height="14"/>
    <rect id="矩形_4_拷贝_16-4" data-name="矩形 4 拷贝 16" class="cls-1" x="559" y="597" width="14" height="14"/>
    <rect id="矩形_3_拷贝_60-2" data-name="矩形 3 拷贝 60" class="cls-1" x="564" y="486" width="4" height="120"/>
  </g>
  <rect id="矩形_3_拷贝_63" data-name="矩形 3 拷贝 63" class="cls-1" x="693" y="386" width="2" height="220"/>
  <rect id="矩形_3_拷贝_66" data-name="矩形 3 拷贝 66" class="cls-1" x="963" y="386" width="2" height="220"/>
  <rect id="矩形_3_拷贝_64" data-name="矩形 3 拷贝 64" class="cls-1" x="693" y="604" width="273" height="2"/>
  <rect id="矩形_3_拷贝_65" data-name="矩形 3 拷贝 65" class="cls-1" x="693" y="386" width="273" height="2"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="1423" y="261" width="156" height="4"/>
  <g id="组_14" data-name="组 14">
    <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="587" y="227" width="18" height="4"/>
    <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="625" y="227" width="108" height="4"/>
    <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="596" y="105" width="137" height="4"/>
    <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="676" y="158" width="50" height="2"/>
    <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="676" y="204" width="50" height="2"/>
    <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="595" y="170" width="4" height="57"/>
    <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="595" y="184" width="41" height="4"/>
    <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="676" y="108" width="4" height="119"/>
    <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="105" width="4" height="20"/>
    <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="139" width="4" height="20"/>
    <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="174" width="4" height="24"/>
    <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="729" y="213" width="4" height="18"/>
    <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="171" width="1" height="24"/>
    <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="633" y="108" width="4" height="80"/>
    <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="725" y="167" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="167" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,166h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,199l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="690" y="171" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="194" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="171" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="166" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="199" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="122" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="725" y="118" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="118" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,117h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-2" d="M696,150l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="690" y="122" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="145" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="684" y="122" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="117" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="696" y="150" width="30" height="1"/>
    <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="227" width="57" height="4"/>
    <rect id="矩形_3_拷贝_53-2" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="105" width="57" height="4"/>
    <rect id="矩形_3_拷贝_53-3" data-name="矩形 3 拷贝 53" class="cls-1" x="788" y="158" width="50" height="2"/>
    <rect id="矩形_3_拷贝_53-4" data-name="矩形 3 拷贝 53" class="cls-1" x="788" y="204" width="50" height="2"/>
    <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="834" y="98" width="4" height="129"/>
    <rect id="矩形_3_拷贝_53-5" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="105" width="4" height="20"/>
    <rect id="矩形_3_拷贝_53-6" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="139" width="4" height="20"/>
    <rect id="矩形_3_拷贝_53-7" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="174" width="4" height="24"/>
    <rect id="矩形_3_拷贝_53-8" data-name="矩形 3 拷贝 53" class="cls-1" x="781" y="213" width="4" height="18"/>
    <rect id="矩形_5_拷贝_18" data-name="矩形 5 拷贝 18" class="cls-1" x="829" y="171" width="1" height="24"/>
    <rect id="矩形_5_拷贝_18-2" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="167" width="1" height="32"/>
    <rect id="矩形_5_拷贝_18-3" data-name="矩形 5 拷贝 18" class="cls-1" x="817" y="167" width="1" height="32"/>
    <path id="矩形_5_拷贝_18-4" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,166h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_18-5" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,199l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_18-6" data-name="矩形 5 拷贝 18" class="cls-1" x="823" y="171" width="1" height="24"/>
    <rect id="矩形_5_拷贝_18-7" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="194" width="6" height="1"/>
    <rect id="矩形_5_拷贝_18-8" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="171" width="6" height="1"/>
    <rect id="矩形_5_拷贝_18-9" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="166" width="30" height="1"/>
    <rect id="矩形_5_拷贝_18-10" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="199" width="30" height="1"/>
    <rect id="矩形_5_拷贝_18-11" data-name="矩形 5 拷贝 18" class="cls-1" x="829" y="122" width="1" height="24"/>
    <rect id="矩形_5_拷贝_18-12" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="118" width="1" height="32"/>
    <rect id="矩形_5_拷贝_18-13" data-name="矩形 5 拷贝 18" class="cls-1" x="817" y="118" width="1" height="32"/>
    <path id="矩形_5_拷贝_18-14" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,117h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_18-15" data-name="矩形 5 拷贝 18" class="cls-2" d="M818,150l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_18-16" data-name="矩形 5 拷贝 18" class="cls-1" x="823" y="122" width="1" height="24"/>
    <rect id="矩形_5_拷贝_18-17" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="145" width="6" height="1"/>
    <rect id="矩形_5_拷贝_18-18" data-name="矩形 5 拷贝 18" class="cls-1" x="824" y="122" width="6" height="1"/>
    <rect id="矩形_5_拷贝_18-19" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="117" width="30" height="1"/>
    <rect id="矩形_5_拷贝_18-20" data-name="矩形 5 拷贝 18" class="cls-1" x="788" y="150" width="30" height="1"/>
  </g>
  <rect id="矩形_5" data-name="矩形 5" class="cls-3" x="679" y="365" width="29" height="29"/>
  <rect id="矩形_5_拷贝_2" data-name="矩形 5 拷贝 2" class="cls-3" x="954" y="365" width="29" height="29"/>
  <path id="矩形_5_拷贝" data-name="矩形 5 拷贝" class="cls-4" d="M899,394H749V362h15v3H899v-3h15v32H899Z"/>
</svg>


EFO;
                return \show(1, 'OK', $data, 200);
                break;
            case ($floor == 3):
                $data[0] = [
                    'floor' => '3',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '会议室&健身房',
                    'room_number' => 301,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="组_11" data-name="组 11" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1792 706">
<defs>
    <style>
      .cls-1, .cls-3 {
        fill: #585b7a;
      }

      .cls-2 {
        fill: #f1f2f9;
      }

      .cls-3 {
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="607" y="631" width="1092" height="6"/>
  <rect id="矩形_4_拷贝_16" data-name="矩形 4 拷贝 16" class="cls-1" x="1173" y="506" width="14" height="14"/>
  <rect id="矩形_4_拷贝_16-2" data-name="矩形 4 拷贝 16" class="cls-1" x="1173" y="620" width="14" height="14"/>
  <rect id="矩形_3_拷贝_60" data-name="矩形 3 拷贝 60" class="cls-1" x="1178" y="509" width="4" height="41"/>
  <rect id="矩形_3_拷贝_122" data-name="矩形 3 拷贝 122" class="cls-1" x="894" y="506" width="293" height="4"/>
  <rect id="矩形_4_拷贝_29" data-name="矩形 4 拷贝 29" class="cls-1" x="1038" y="96" width="14" height="14"/>
  <rect id="矩形_4_拷贝_30" data-name="矩形 4 拷贝 30" class="cls-1" x="1038" y="220" width="14" height="14"/>
  <rect id="矩形_3_拷贝_84" data-name="矩形 3 拷贝 84" class="cls-1" x="1043" y="99" width="4" height="134"/>
  <rect id="矩形_4_拷贝_31" data-name="矩形 4 拷贝 31" class="cls-1" x="603" y="96" width="14" height="14"/>
  <rect id="矩形_4_拷贝_31-2" data-name="矩形 4 拷贝 31" class="cls-1" x="603" y="220" width="14" height="14"/>
  <rect id="矩形_3_拷贝_87" data-name="矩形 3 拷贝 87" class="cls-1" x="608" y="99" width="4" height="134"/>
  <rect id="矩形_4_拷贝_32" data-name="矩形 4 拷贝 32" class="cls-1" x="471" y="96" width="14" height="14"/>
  <rect id="矩形_4_拷贝_32-2" data-name="矩形 4 拷贝 32" class="cls-1" x="471" y="220" width="14" height="14"/>
  <rect id="矩形_3_拷贝_88" data-name="矩形 3 拷贝 88" class="cls-1" x="476" y="99" width="4" height="134"/>
  <rect id="矩形_4_拷贝_33" data-name="矩形 4 拷贝 33" class="cls-1" x="336" y="96" width="14" height="14"/>
  <rect id="矩形_4_拷贝_33-2" data-name="矩形 4 拷贝 33" class="cls-1" x="336" y="220" width="14" height="14"/>
  <rect id="矩形_4_拷贝_34" data-name="矩形 4 拷贝 34" class="cls-1" x="220" y="220" width="14" height="14"/>
  <rect id="矩形_3_拷贝_89" data-name="矩形 3 拷贝 89" class="cls-1" x="342" y="99" width="4" height="134"/>
  <rect id="矩形_3_拷贝_94" data-name="矩形 3 拷贝 94" class="cls-1" x="340" y="99" width="6" height="86"/>
  <rect id="矩形_3_拷贝_90" data-name="矩形 3 拷贝 90" class="cls-1" x="350" y="230" width="50" height="4"/>
  <rect id="矩形_3_拷贝_95" data-name="矩形 3 拷贝 95" class="cls-1" x="254" y="230" width="82" height="4"/>
  <rect id="矩形_4_拷贝_37" data-name="矩形 4 拷贝 37" class="cls-1" x="336" y="271" width="14" height="14"/>
  <rect id="矩形_4_拷贝_38" data-name="矩形 4 拷贝 38" class="cls-1" x="225" y="271" width="14" height="14"/>
  <rect id="矩形_4_拷贝_39" data-name="矩形 4 拷贝 39" class="cls-1" x="225" y="384" width="14" height="14"/>
  <rect id="矩形_4_拷贝_41" data-name="矩形 4 拷贝 41" class="cls-1" x="225" y="504" width="14" height="14"/>
  <rect id="矩形_4_拷贝_40" data-name="矩形 4 拷贝 40" class="cls-1" x="338" y="384" width="14" height="14"/>
  <rect id="矩形_3_拷贝_107" data-name="矩形 3 拷贝 107" class="cls-1" x="298" y="271" width="39" height="4"/>
  <rect id="矩形_3_拷贝_109" data-name="矩形 3 拷贝 109" class="cls-1" x="236" y="271" width="39" height="4"/>
  <rect id="矩形_3_拷贝_108" data-name="矩形 3 拷贝 108" class="cls-1" x="346" y="271" width="82" height="4"/>
  <rect id="矩形_4_拷贝_42" data-name="矩形 4 拷贝 42" class="cls-1" x="476" y="271" width="14" height="14"/>
  <rect id="矩形_4_拷贝_44" data-name="矩形 4 拷贝 44" class="cls-1" x="732" y="271" width="14" height="14"/>
  <rect id="矩形_4_拷贝_45" data-name="矩形 4 拷贝 45" class="cls-1" x="732" y="384" width="14" height="14"/>
  <rect id="矩形_4_拷贝_46" data-name="矩形 4 拷贝 46" class="cls-1" x="732" y="508" width="14" height="14"/>
  <rect id="矩形_4_拷贝_43" data-name="矩形 4 拷贝 43" class="cls-1" x="476" y="384" width="14" height="14"/>
  <rect id="矩形_3_拷贝_115" data-name="矩形 3 拷贝 115" class="cls-1" x="490" y="271" width="39" height="4"/>
  <rect id="矩形_3_拷贝_118" data-name="矩形 3 拷贝 118" class="cls-1" x="742" y="284" width="4" height="39"/>
  <rect id="矩形_3_拷贝_119" data-name="矩形 3 拷贝 119" class="cls-1" x="742" y="345" width="4" height="39"/>
  <rect id="矩形_3_拷贝_120" data-name="矩形 3 拷贝 120" class="cls-1" x="742" y="397" width="4" height="51"/>
  <rect id="矩形_3_拷贝_120-2" data-name="矩形 3 拷贝 120" class="cls-1" x="742" y="469" width="4" height="91"/>
  <rect id="矩形_3_拷贝_121" data-name="矩形 3 拷贝 121" class="cls-1" x="742" y="584" width="4" height="47"/>
  <rect id="矩形_3_拷贝_117" data-name="矩形 3 拷贝 117" class="cls-1" x="471" y="394" width="271" height="4"/>
  <rect id="矩形_3_拷贝_115-2" data-name="矩形 3 拷贝 115" class="cls-1" x="557" y="271" width="185" height="4"/>
  <rect id="矩形_3_拷贝_111" data-name="矩形 3 拷贝 111" class="cls-1" x="239" y="394" width="196" height="4"/>
  <rect id="矩形_3_拷贝_110" data-name="矩形 3 拷贝 110" class="cls-1" x="426" y="271" width="4" height="127"/>
  <rect id="矩形_3_拷贝_116" data-name="矩形 3 拷贝 116" class="cls-1" x="476" y="271" width="4" height="127"/>
  <rect id="矩形_3_拷贝_112" data-name="矩形 3 拷贝 112" class="cls-1" x="225" y="271" width="4" height="127"/>
  <rect id="矩形_3_拷贝_113" data-name="矩形 3 拷贝 113" class="cls-1" x="225" y="426" width="4" height="166"/>
  <rect id="矩形_3_拷贝_114" data-name="矩形 3 拷贝 114" class="cls-1" x="225" y="619" width="4" height="34"/>
  <rect id="矩形_3_拷贝_97" data-name="矩形 3 拷贝 97" class="cls-1" x="102" y="226" width="58" height="4"/>
  <rect id="矩形_3_拷贝_100" data-name="矩形 3 拷贝 100" class="cls-1" x="102" y="272" width="88" height="4"/>
  <rect id="矩形_3_拷贝_103" data-name="矩形 3 拷贝 103" class="cls-1" x="102" y="397" width="88" height="4"/>
  <rect id="矩形_3_拷贝_98" data-name="矩形 3 拷贝 98" class="cls-1" x="156" y="202" width="4" height="50"/>
  <rect id="矩形_3_拷贝_101" data-name="矩形 3 拷贝 101" class="cls-1" x="186" y="190" width="4" height="30"/>
  <rect id="矩形_3_拷贝_102" data-name="矩形 3 拷贝 102" class="cls-1" x="186" y="242" width="4" height="137"/>
  <rect id="矩形_3_拷贝_99" data-name="矩形 3 拷贝 99" class="cls-1" x="102" y="190" width="6" height="465"/>
  <rect id="矩形_3_拷贝_106" data-name="矩形 3 拷贝 106" class="cls-1" x="102" y="652" width="506" height="6"/>
  <rect id="矩形_3_拷贝_96" data-name="矩形 3 拷贝 96" class="cls-1" x="226" y="190" width="4" height="44"/>
  <rect id="矩形_3_拷贝_93" data-name="矩形 3 拷贝 93" class="cls-1" x="102" y="184" width="240" height="6"/>
  <rect id="矩形_3_拷贝_91" data-name="矩形 3 拷贝 91" class="cls-1" x="422" y="230" width="50" height="4"/>
  <rect id="矩形_3_拷贝_92" data-name="矩形 3 拷贝 92" class="cls-1" x="483" y="230" width="50" height="4"/>
  <rect id="矩形_3_拷贝_92-2" data-name="矩形 3 拷贝 92" class="cls-1" x="555" y="230" width="50" height="4"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1178" y="579" width="4" height="41"/>
  <rect id="矩形_4_拷贝_17" data-name="矩形 4 拷贝 17" class="cls-1" x="893" y="506" width="14" height="14"/>
  <rect id="矩形_4_拷贝_18" data-name="矩形 4 拷贝 18" class="cls-1" x="893" y="384" width="14" height="14"/>
  <rect id="矩形_4_拷贝_19" data-name="矩形 4 拷贝 19" class="cls-1" x="893" y="267" width="14" height="14"/>
  <rect id="矩形_4_拷贝_17-2" data-name="矩形 4 拷贝 17" class="cls-1" x="893" y="620" width="14" height="14"/>
  <rect id="矩形_4_拷贝_35" data-name="矩形 4 拷贝 35" class="cls-1" x="601" y="620" width="14" height="14"/>
  <rect id="矩形_4_拷贝_36" data-name="矩形 4 拷贝 36" class="cls-1" x="601" y="634" width="7" height="18"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="898" y="498" width="4" height="49"/>
  <rect id="矩形_3_拷贝_64" data-name="矩形 3 拷贝 64" class="cls-1" x="898" y="271" width="4" height="22"/>
  <rect id="矩形_4_拷贝_20" data-name="矩形 4 拷贝 20" class="cls-1" x="1038" y="267" width="14" height="14"/>
  <rect id="矩形_4_拷贝_21" data-name="矩形 4 拷贝 21" class="cls-1" x="1176" y="267" width="14" height="14"/>
  <rect id="矩形_4_拷贝_22" data-name="矩形 4 拷贝 22" class="cls-1" x="1309" y="267" width="14" height="14"/>
  <rect id="矩形_4_拷贝_23" data-name="矩形 4 拷贝 23" class="cls-1" x="1309" y="220" width="14" height="14"/>
  <rect id="矩形_3_拷贝_65" data-name="矩形 3 拷贝 65" class="cls-1" x="906" y="267" width="370" height="4"/>
  <rect id="矩形_3_拷贝_66" data-name="矩形 3 拷贝 66" class="cls-1" x="1319" y="90" width="4" height="177"/>
  <rect id="矩形_3_拷贝_85" data-name="矩形 3 拷贝 85" class="cls-1" x="1269" y="90" width="4" height="104"/>
  <rect id="矩形_3_拷贝_86" data-name="矩形 3 拷贝 86" class="cls-1" x="1240" y="190" width="65" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="1382" y="90" width="4" height="177"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="1341" y="231" width="86" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1499" y="388" width="24" height="4"/>
  <rect id="矩形_3_拷贝_80" data-name="矩形 3 拷贝 80" class="cls-1" x="1360" y="313" width="24" height="5"/>
  <rect id="矩形_3_拷贝_81" data-name="矩形 3 拷贝 81" class="cls-1" x="1439" y="313" width="24" height="5"/>
  <rect id="矩形_3_拷贝_82" data-name="矩形 3 拷贝 82" class="cls-1" x="1439" y="459" width="24" height="5"/>
  <rect id="矩形_3_拷贝_83" data-name="矩形 3 拷贝 83" class="cls-1" x="1360" y="459" width="24" height="5"/>
  <rect id="矩形_3_拷贝_78" data-name="矩形 3 拷贝 78" class="cls-1" x="1545" y="388" width="24" height="4"/>
  <rect id="矩形_3_拷贝_79" data-name="矩形 3 拷贝 79" class="cls-1" x="1572" y="518" width="59" height="4"/>
  <rect id="矩形_3_拷贝_77" data-name="矩形 3 拷贝 77" class="cls-1" x="1564" y="392" width="4" height="118"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="1322" y="261" width="35" height="4"/>
  <rect id="矩形_3_拷贝_74" data-name="矩形 3 拷贝 74" class="cls-1" x="1417" y="261" width="35" height="4"/>
  <rect id="矩形_4_拷贝_25" data-name="矩形 4 拷贝 25" class="cls-1" x="1442" y="265" width="14" height="14"/>
  <rect id="矩形_4_拷贝_26" data-name="矩形 4 拷贝 26" class="cls-1" x="1559" y="385" width="14" height="14"/>
  <rect id="矩形_4_拷贝_28" data-name="矩形 4 拷贝 28" class="cls-2" x="1305" y="383" width="151" height="14"/>
  <rect id="矩形_4_拷贝_27" data-name="矩形 4 拷贝 27" class="cls-1" x="1559" y="508" width="14" height="14"/>
  <rect id="矩形_4_拷贝_25-2" data-name="矩形 4 拷贝 25" class="cls-1" x="1442" y="217" width="14" height="14"/>
  <rect id="矩形_3_拷贝_67" data-name="矩形 3 拷贝 67" class="cls-1" x="1452" y="101" width="4" height="166"/>
  <rect id="矩形_3_拷贝_75" data-name="矩形 3 拷贝 75" class="cls-1" x="1452" y="101" width="6" height="90"/>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="1456" y="185" width="246" height="6"/>
  <rect id="矩形_3_拷贝_68" data-name="矩形 3 拷贝 68" class="cls-1" x="336" y="90" width="1049" height="6"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1385" y="101" width="67" height="6"/>
  <rect id="矩形_3_拷贝_63" data-name="矩形 3 拷贝 63" class="cls-1" x="898" y="318" width="4" height="155"/>
  <rect id="矩形_3_拷贝_62-2" data-name="矩形 3 拷贝 62" class="cls-1" x="898" y="579" width="4" height="41"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="1699" y="506" width="6" height="131"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="1699" y="185" width="6" height="321"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="1631" y="510" width="4" height="91"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="1631" y="623" width="4" height="8"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="1631" y="506" width="68" height="4"/>
  <rect id="矩形_5_拷贝_22" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="560" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-2" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="564" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-3" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="568" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-4" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="572" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-5" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="576" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-6" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="580" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-7" data-name="矩形 5 拷贝 22" class="cls-1" x="1654" y="584" width="25" height="1"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="157" y="512" width="4" height="91"/>
  <rect id="矩形_3_拷贝_47-2" data-name="矩形 3 拷贝 47" class="cls-1" x="157" y="625" width="4" height="28"/>
  <rect id="矩形_3_拷贝_47-3" data-name="矩形 3 拷贝 47" class="cls-1" x="103" y="508" width="87" height="4"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="186" y="464" width="4" height="47"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="186" y="529" width="4" height="47"/>
  <rect id="矩形_3_拷贝_58" data-name="矩形 3 拷贝 58" class="cls-1" x="161" y="576" width="29" height="4"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="186" y="397" width="4" height="44"/>
  <rect id="矩形_5_拷贝_23" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="562" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-2" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="566" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-3" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="570" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-4" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="574" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-5" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="578" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-6" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="582" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23-7" data-name="矩形 5 拷贝 23" class="cls-1" x="113" y="586" width="25" height="1"/>
  <path id="矩形_2" data-name="矩形 2" class="cls-3" d="M1482,463h-43V314h43a20,20,0,0,1,20,20V443A20,20,0,0,1,1482,463Zm-98,0h-43a20,20,0,0,1-20-20V334a20,20,0,0,1,20-20h43V463Zm95.88-3h-41.1V317h41.1A19.157,19.157,0,0,1,1499,336.2v104.61A19.157,19.157,0,0,1,1479.88,460Zm-95.66,0h-41.1A19.157,19.157,0,0,1,1324,440.805V336.2A19.157,19.157,0,0,1,1343.12,317h41.1V460Z"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1207" y="230" width="18" height="4"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="1258" y="230" width="61" height="4"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="1178" y="219" width="4" height="12"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1128" y="96" width="4" height="137"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1221" y="96" width="4" height="138"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1178" y="96" width="4" height="109"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="1128" y="230" width="60" height="4"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="914" y="230" width="192" height="4"/>
  <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="1190" y="104" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="1186" y="145" width="32" height="1"/>
  <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="1186" y="116" width="32" height="1"/>
  <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-3" d="M1185,116v1l34,29v-1Z"/>
  <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-3" d="M1218,116l-33,30h1l33-30h-1Z"/>
  <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="1190" y="110" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="1213" y="104" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="1190" y="104" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="1185" y="116" width="1" height="30"/>
  <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="1218" y="116" width="1" height="30"/>
  <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="646" y="230" width="18" height="4"/>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="684" y="230" width="108" height="4"/>
  <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="653" y="108" width="139" height="4"/>
  <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="735" y="161" width="50" height="2"/>
  <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="735" y="207" width="50" height="2"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="653" y="165" width="4" height="65"/>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="654" y="187" width="41" height="4"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="735" y="111" width="4" height="119"/>
  <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="788" y="108" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="788" y="142" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="788" y="177" width="4" height="24"/>
  <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="788" y="216" width="4" height="18"/>
  <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="174" width="1" height="24"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="692" y="111" width="4" height="80"/>
  <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="784" y="170" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="170" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-3" d="M755,169h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-3" d="M755,202l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="749" y="174" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="197" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="174" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="169" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="202" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="125" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="784" y="121" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="121" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-3" d="M755,120h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-3" d="M755,153l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="749" y="125" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="148" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="743" y="125" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="120" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="755" y="153" width="30" height="1"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="230" width="57" height="4"/>
  <rect id="矩形_3_拷贝_53-2" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="108" width="57" height="4"/>
  <rect id="矩形_3_拷贝_53-3" data-name="矩形 3 拷贝 53" class="cls-1" x="847" y="161" width="50" height="2"/>
  <rect id="矩形_3_拷贝_53-4" data-name="矩形 3 拷贝 53" class="cls-1" x="847" y="207" width="50" height="2"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="893" y="92" width="4" height="138"/>
  <rect id="矩形_3_拷贝_53-5" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="108" width="4" height="20"/>
  <rect id="矩形_3_拷贝_53-6" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="142" width="4" height="20"/>
  <rect id="矩形_3_拷贝_53-7" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="177" width="4" height="24"/>
  <rect id="矩形_3_拷贝_53-8" data-name="矩形 3 拷贝 53" class="cls-1" x="840" y="216" width="4" height="18"/>
  <rect id="矩形_5_拷贝_18" data-name="矩形 5 拷贝 18" class="cls-1" x="888" y="174" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-2" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="170" width="1" height="32"/>
  <rect id="矩形_5_拷贝_18-3" data-name="矩形 5 拷贝 18" class="cls-1" x="876" y="170" width="1" height="32"/>
  <path id="矩形_5_拷贝_18-4" data-name="矩形 5 拷贝 18" class="cls-3" d="M877,169h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_18-5" data-name="矩形 5 拷贝 18" class="cls-3" d="M877,202l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_18-6" data-name="矩形 5 拷贝 18" class="cls-1" x="882" y="174" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-7" data-name="矩形 5 拷贝 18" class="cls-1" x="883" y="197" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-8" data-name="矩形 5 拷贝 18" class="cls-1" x="883" y="174" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-9" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="169" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-10" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="202" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-11" data-name="矩形 5 拷贝 18" class="cls-1" x="888" y="125" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-12" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="121" width="1" height="32"/>
  <rect id="矩形_5_拷贝_18-13" data-name="矩形 5 拷贝 18" class="cls-1" x="876" y="121" width="1" height="32"/>
  <path id="矩形_5_拷贝_18-14" data-name="矩形 5 拷贝 18" class="cls-3" d="M877,120h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_18-15" data-name="矩形 5 拷贝 18" class="cls-3" d="M877,153l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_18-16" data-name="矩形 5 拷贝 18" class="cls-1" x="882" y="125" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-17" data-name="矩形 5 拷贝 18" class="cls-1" x="883" y="148" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-18" data-name="矩形 5 拷贝 18" class="cls-1" x="883" y="125" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-19" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="120" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-20" data-name="矩形 5 拷贝 18" class="cls-1" x="847" y="153" width="30" height="1"/>
  <rect id="矩形_3_拷贝_70-2" data-name="矩形 3 拷贝 70" class="cls-1" x="654" y="170" width="42" height="4"/>
  <rect id="矩形_3_拷贝_71-2" data-name="矩形 3 拷贝 71" class="cls-1" x="654" y="139" width="42" height="4"/>
  <rect id="矩形_3_拷贝_72-2" data-name="矩形 3 拷贝 72" class="cls-1" x="653" y="132" width="4" height="18"/>
  <rect id="矩形_3_拷贝_73-2" data-name="矩形 3 拷贝 73" class="cls-1" x="653" y="108" width="4" height="10"/>
  <rect id="矩形_3_拷贝_69-2" data-name="矩形 3 拷贝 69" class="cls-1" x="1178" y="153" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76-2" data-name="矩形 3 拷贝 76" class="cls-1" x="1214" y="153" width="11" height="4"/>
  <g id="组_20" data-name="组 20">
    <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="158" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="162" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="182" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="186" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="166" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="170" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="174" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="698" y="178" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="137" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="141" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="128" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="132" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="145" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="149" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="153" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="718" y="157" width="15" height="1"/>
    <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="715" y="122" width="1" height="71"/>
    <rect id="矩形_5_拷贝_30" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="158" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-2" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="162" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-3" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="182" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-4" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="186" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-5" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="166" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-6" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="170" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-7" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="174" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-8" data-name="矩形 5 拷贝 30" class="cls-1" x="1136" y="178" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-9" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="137" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-10" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="141" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-11" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="128" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-12" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="132" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-13" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="145" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-14" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="149" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-15" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="153" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-16" data-name="矩形 5 拷贝 30" class="cls-1" x="1157" y="157" width="16" height="1"/>
    <rect id="矩形_5_拷贝_30-17" data-name="矩形 5 拷贝 30" class="cls-1" x="1154" y="122" width="1" height="71"/>
  </g>
</svg>

EFO;

                return \show(1, 'OK', $data, 200);
                break;
            case($floor == 4):
                $data[0] = [
                    'floor' => '4',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '众创中心',
                    'room_number' => 401,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="组_21" data-name="组 21" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1621 620">
<defs>
    <style>
      .cls-1, .cls-2 {
        fill: #585b7a;
      }

      .cls-2 {
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="469.281" y="194" width="53.719" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="468" y="154" width="53.719" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="467" y="147" width="4" height="18"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="467" y="116" width="4" height="10"/>
  <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="199" y="510" width="1180" height="6"/>
  <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="192" y="93" width="6" height="19"/>
  <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="1373" y="475" width="6" height="41"/>
  <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="193" y="475" width="6" height="41"/>
  <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="91" y="475" width="102" height="6"/>
  <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1475" y="117" width="6" height="360"/>
  <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="91" y="106" width="6" height="370"/>
  <rect id="矩形_3_拷贝_17" data-name="矩形 3 拷贝 17" class="cls-1" x="1382" y="94" width="6" height="24"/>
  <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="1387" y="112" width="94" height="6"/>
  <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="94" y="106" width="98" height="6"/>
  <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="197" y="93" width="1191" height="6"/>
  <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="1377" y="475" width="104" height="6"/>
  <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="1353" y="315" width="124" height="4"/>
  <rect id="矩形_3_拷贝_30" data-name="矩形 3 拷贝 30" class="cls-1" x="1356" y="270" width="120" height="4"/>
  <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="92" y="466" width="14" height="14"/>
  <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="91" y="111" width="14" height="14"/>
  <rect id="矩形_4" data-name="矩形 4" class="cls-1" x="1467" y="257" width="14" height="14"/>
  <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="1467" y="112" width="14" height="14"/>
  <rect id="矩形_4_拷贝-2" data-name="矩形 4 拷贝" class="cls-1" x="1467" y="315" width="14" height="14"/>
  <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1467" y="467" width="14" height="14"/>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="91" y="318" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="91" y="257" width="14" height="14"/>
  <rect id="矩形_3_拷贝_4" data-name="矩形 3 拷贝 4" class="cls-1" x="93" y="315" width="132" height="4"/>
  <rect id="矩形_3_拷贝_6" data-name="矩形 3 拷贝 6" class="cls-1" x="282" y="315" width="184" height="4"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="813" y="271" width="225" height="4"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="306" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="94" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="251" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_10" data-name="矩形 3 拷贝 10" class="cls-1" x="455" y="315" width="146" height="4"/>
  <rect id="矩形_3_拷贝_12" data-name="矩形 3 拷贝 12" class="cls-1" x="634" y="315" width="155" height="4"/>
  <rect id="矩形_3_拷贝_15" data-name="矩形 3 拷贝 15" class="cls-1" x="821" y="315" width="157" height="4"/>
  <rect id="矩形_3_拷贝_16" data-name="矩形 3 拷贝 16" class="cls-1" x="1027" y="315" width="104" height="4"/>
  <rect id="矩形_3_拷贝_19" data-name="矩形 3 拷贝 19" class="cls-1" x="1182" y="315" width="135" height="4"/>
  <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="422" y="257" width="14" height="14"/>
  <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="422" y="111" width="14" height="14"/>
  <rect id="矩形_3_拷贝_22" data-name="矩形 3 拷贝 22" class="cls-1" x="427" y="98" width="4" height="166"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11-2" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_26" data-name="矩形 3 拷贝 26" class="cls-1" x="780" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12-2" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_27" data-name="矩形 3 拷贝 27" class="cls-1" x="969" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_14-2" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_29" data-name="矩形 3 拷贝 29" class="cls-1" x="1308" y="326" width="4" height="184"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="727" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="727" y="112" width="64" height="4"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="727" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="727" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="787" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="727" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="727" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="727" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="727" y="246" width="4" height="29"/>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="507" y="271" width="85" height="4"/>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="467" y="211" width="56" height="4"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="455" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="467" y="183" width="4" height="88"/>
  <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="467" y="112" width="186" height="4"/>
  <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="519" y="115" width="4" height="112"/>
  <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="519" y="255" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-9" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="246" width="4" height="29"/>
  <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="174" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="174" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,173h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,206l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="178" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="201" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="173" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="206" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="126" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="126" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,125h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,158l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="130" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="153" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="125" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="158" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="777" y="178" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="174" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="174" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-2" d="M766,173h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-2" d="M766,206l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="771" y="178" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="772" y="201" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="772" y="178" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="173" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="206" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-31" data-name="矩形 5 拷贝 17" class="cls-1" x="777" y="130" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-32" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="126" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-33" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="126" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-34" data-name="矩形 5 拷贝 17" class="cls-2" d="M766,125h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_17-35" data-name="矩形 5 拷贝 17" class="cls-2" d="M766,158l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-36" data-name="矩形 5 拷贝 17" class="cls-1" x="771" y="130" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-37" data-name="矩形 5 拷贝 17" class="cls-1" x="772" y="153" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-38" data-name="矩形 5 拷贝 17" class="cls-1" x="772" y="130" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-39" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="125" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-40" data-name="矩形 5 拷贝 17" class="cls-1" x="736" y="158" width="30" height="1"/>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="1237" y="271" width="83" height="4"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1180" y="271" width="18" height="4"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="1068" y="271" width="79" height="4"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1143" y="257" width="4" height="18"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1216" y="216" width="76" height="4"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="1251" y="94" width="2" height="124"/>
  <rect id="矩形_3_拷贝_22-2" data-name="矩形 3 拷贝 22" class="cls-1" x="1311" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1194" y="97" width="4" height="178"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="1068" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1143" y="97" width="4" height="129"/>
  <rect id="矩形_4-2" data-name="矩形 4" class="cls-1" x="1306" y="257" width="14" height="14"/>
  <rect id="矩形_4_拷贝-3" data-name="矩形 4 拷贝" class="cls-1" x="1306" y="111" width="14" height="14"/>
  <rect id="矩形_5_拷贝_17-41" data-name="矩形 5 拷贝 17" class="cls-1" x="1159" y="109" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-42" data-name="矩形 5 拷贝 17" class="cls-1" x="1155" y="150" width="32" height="1"/>
  <rect id="矩形_5_拷贝_17-43" data-name="矩形 5 拷贝 17" class="cls-1" x="1155" y="121" width="32" height="1"/>
  <path id="矩形_5_拷贝_17-44" data-name="矩形 5 拷贝 17" class="cls-2" d="M1154,121v1l34,29v-1Z"/>
  <path id="矩形_5_拷贝_17-45" data-name="矩形 5 拷贝 17" class="cls-2" d="M1187,121l-33,30h1l33-30h-1Z"/>
  <rect id="矩形_5_拷贝_17-46" data-name="矩形 5 拷贝 17" class="cls-1" x="1159" y="115" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-47" data-name="矩形 5 拷贝 17" class="cls-1" x="1182" y="109" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-48" data-name="矩形 5 拷贝 17" class="cls-1" x="1159" y="109" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-49" data-name="矩形 5 拷贝 17" class="cls-1" x="1154" y="121" width="1" height="30"/>
  <rect id="矩形_5_拷贝_17-50" data-name="矩形 5 拷贝 17" class="cls-1" x="1187" y="121" width="1" height="30"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1144" y="159" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1186" y="159" width="11" height="4"/>
  <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="183" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="187" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="207" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="211" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="191" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="195" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="199" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="203" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="162" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="166" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="153" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="157" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="170" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="174" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="178" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="182" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="556" y="147" width="1" height="71"/>
  <rect id="矩形_5_拷贝_29-18" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="183" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-19" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="187" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-20" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="207" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-21" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="211" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-22" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="191" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-23" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="195" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-24" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="199" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-25" data-name="矩形 5 拷贝 29" class="cls-1" x="1079" y="203" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-26" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="162" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-27" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="166" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-28" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="153" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-29" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="157" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-30" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="170" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-31" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="174" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-32" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="178" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-33" data-name="矩形 5 拷贝 29" class="cls-1" x="1109" y="182" width="25" height="1"/>
  <rect id="矩形_5_拷贝_29-34" data-name="矩形 5 拷贝 29" class="cls-1" x="1106" y="147" width="1" height="71"/>
</svg>


EFO;

                return \show(1, 'OK', $data, 200);
                break;
            case($floor == 22):
                $data[0] = [
                    'floor' => '22',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '园区管理办公室',
                    'room_number' => 2201,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="边" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="650" height="248" viewBox="0 0 1621 620">
<defs>
    <style>
      .cls-1, .cls-2 {
        fill: #585b7a;
      }

      .cls-2, .cls-5 {
        fill-rule: evenodd;
      }

      .cls-3 {
        filter: url(#filter);
      }

      .cls-4, .cls-5 {
        fill: #54befc;
      }
    </style>
    <filter id="filter" filterUnits="userSpaceOnUse">
      <feFlood result="flood" flood-color="#ffde83"/>
      <feComposite result="composite" operator="in" in2="SourceGraphic"/>
      <feBlend result="blend" in2="SourceGraphic"/>
    </filter>
  </defs>
  <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="199" y="510" width="1191" height="6"/>
  <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="192" y="93" width="6" height="19"/>
  <rect id="矩形_3_拷贝_17" data-name="矩形 3 拷贝 17" class="cls-1" x="1382" y="94" width="6" height="24"/>
  <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="1386" y="350" width="4" height="166"/>
  <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="193" y="475" width="6" height="41"/>
  <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="91" y="475" width="102" height="6"/>
  <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1475" y="117" width="6" height="360"/>
  <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="91" y="106" width="6" height="370"/>
  <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="1387" y="112" width="94" height="6"/>
  <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="94" y="106" width="98" height="6"/>
  <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="197" y="93" width="1191" height="6"/>
  <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="1388" y="475" width="93" height="6"/>
  <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="1353" y="315" width="124" height="4"/>
  <rect id="矩形_3_拷贝_30" data-name="矩形 3 拷贝 30" class="cls-1" x="1356" y="270" width="120" height="4"/>
  <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="91" y="466" width="14" height="14"/>
  <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="91" y="111" width="14" height="14"/>
  <rect id="矩形_4" data-name="矩形 4" class="cls-1" x="1467" y="259" width="14" height="14"/>
  <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="1467" y="112" width="14" height="14"/>
  <rect id="矩形_4_拷贝-2" data-name="矩形 4 拷贝" class="cls-1" x="1466" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1467" y="465" width="14" height="14"/>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="91" y="315" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="91" y="257" width="14" height="14"/>
  <rect id="矩形_3_拷贝_4" data-name="矩形 3 拷贝 4" class="cls-1" x="93" y="315" width="132" height="4"/>
  <rect id="矩形_3_拷贝_6" data-name="矩形 3 拷贝 6" class="cls-1" x="302" y="315" width="134" height="4"/>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="1237" y="271" width="83" height="4"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1180" y="271" width="18" height="4"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="1068" y="271" width="79" height="4"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="719" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="719" y="112" width="64" height="4"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="719" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="719" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="813" y="271" width="225" height="4"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1143" y="257" width="4" height="18"/>
  <rect id="矩形_5_拷贝_22" data-name="矩形 5 拷贝 22" class="cls-1" x="1080" y="183" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-2" data-name="矩形 5 拷贝 22" class="cls-1" x="1080" y="187" width="25" height="1"/>
  <rect id="矩形_5_拷贝_27" data-name="矩形 5 拷贝 27" class="cls-1" x="1080" y="207" width="25" height="1"/>
  <rect id="矩形_5_拷贝_27-2" data-name="矩形 5 拷贝 27" class="cls-1" x="1080" y="211" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-3" data-name="矩形 5 拷贝 22" class="cls-1" x="1080" y="191" width="25" height="1"/>
  <rect id="矩形_5_拷贝_22-4" data-name="矩形 5 拷贝 22" class="cls-1" x="1080" y="195" width="25" height="1"/>
  <rect id="矩形_5_拷贝_24" data-name="矩形 5 拷贝 24" class="cls-1" x="1080" y="199" width="25" height="1"/>
  <rect id="矩形_5_拷贝_25" data-name="矩形 5 拷贝 25" class="cls-1" x="1080" y="203" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="162" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26-2" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="166" width="25" height="1"/>
  <rect id="矩形_5_拷贝_28" data-name="矩形 5 拷贝 28" class="cls-1" x="1110" y="153" width="25" height="1"/>
  <rect id="矩形_5_拷贝_28-2" data-name="矩形 5 拷贝 28" class="cls-1" x="1110" y="157" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26-3" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="170" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26-4" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="174" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26-5" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="178" width="25" height="1"/>
  <rect id="矩形_5_拷贝_26-6" data-name="矩形 5 拷贝 26" class="cls-1" x="1110" y="182" width="25" height="1"/>
  <rect id="矩形_5_拷贝_23" data-name="矩形 5 拷贝 23" class="cls-1" x="1107" y="147" width="1" height="71"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1216" y="216" width="76" height="4"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="1251" y="92" width="2" height="124"/>
  <rect id="矩形_3_拷贝_22" data-name="矩形 3 拷贝 22" class="cls-1" x="1311" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1194" y="97" width="4" height="178"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="1068" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="779" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="719" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="719" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="719" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="719" y="246" width="4" height="29"/>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="507" y="271" width="85" height="4"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="455" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="306" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="94" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="251" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="466" y="112" width="188" height="4"/>
  <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="519" y="115" width="4" height="112"/>
  <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="519" y="255" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-9" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="246" width="4" height="29"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1143" y="97" width="4" height="129"/>
  <rect id="矩形_4-2" data-name="矩形 4" class="cls-1" x="1306" y="257" width="14" height="14"/>
  <rect id="矩形_4_拷贝-3" data-name="矩形 4 拷贝" class="cls-1" x="1306" y="111" width="14" height="14"/>
  <rect id="矩形_3_拷贝_10" data-name="矩形 3 拷贝 10" class="cls-1" x="455" y="315" width="146" height="4"/>
  <rect id="矩形_3_拷贝_12" data-name="矩形 3 拷贝 12" class="cls-1" x="634" y="315" width="155" height="4"/>
  <rect id="矩形_3_拷贝_15" data-name="矩形 3 拷贝 15" class="cls-1" x="821" y="315" width="116" height="4"/>
  <rect id="矩形_3_拷贝_16" data-name="矩形 3 拷贝 16" class="cls-1" x="1002" y="315" width="114" height="4"/>
  <rect id="矩形_3_拷贝_19" data-name="矩形 3 拷贝 19" class="cls-1" x="1182" y="315" width="135" height="4"/>
  <g id="组_4" data-name="组 4">
    <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="256" y="319" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="256" y="466" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22-2" data-name="矩形 3 拷贝 22" class="cls-1" x="261" y="326" width="4" height="184"/>
  </g>
  <g id="组_4_拷贝" data-name="组 4 拷贝">
    <rect id="矩形_4_拷贝_7-2" data-name="矩形 4 拷贝 7" class="cls-1" x="257" y="257" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8-2" data-name="矩形 4 拷贝 8" class="cls-1" x="257" y="111" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22-3" data-name="矩形 3 拷贝 22" class="cls-1" x="262" y="98" width="4" height="166"/>
  </g>
  <g id="组_4_拷贝_2" data-name="组 4 拷贝 2">
    <rect id="矩形_4_拷贝_7-3" data-name="矩形 4 拷贝 7" class="cls-1" x="422" y="257" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8-3" data-name="矩形 4 拷贝 8" class="cls-1" x="422" y="111" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22-4" data-name="矩形 3 拷贝 22" class="cls-1" x="427" y="98" width="4" height="166"/>
  </g>
  <rect id="矩形_4_拷贝_9" data-name="矩形 4 拷贝 9" class="cls-1" x="422" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_9-2" data-name="矩形 4 拷贝 9" class="cls-1" x="422" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_24" data-name="矩形 3 拷贝 24" class="cls-1" x="427" y="326" width="4" height="184"/>
  <rect id="矩形_3_拷贝_58" data-name="矩形 3 拷贝 58" class="cls-1" x="509" y="351" width="4" height="159"/>
  <rect id="矩形_3_拷贝_68" data-name="矩形 3 拷贝 68" class="cls-1" x="509" y="315" width="4" height="15"/>
  <rect id="矩形_3_拷贝_64" data-name="矩形 3 拷贝 64" class="cls-1" x="874" y="414" width="4" height="95.625"/>
  <rect id="矩形_3_拷贝_59" data-name="矩形 3 拷贝 59" class="cls-1" x="782" y="413" width="71" height="4"/>
  <path id="矩形_3_拷贝_63" data-name="矩形 3 拷贝 63" class="cls-2" d="M1056,317.143h4V511h-4V317.143Z"/>
  <rect id="矩形_3_拷贝_67" data-name="矩形 3 拷贝 67" class="cls-1" x="1226" y="414" width="4" height="97"/>
  <rect id="矩形_3_拷贝_74" data-name="矩形 3 拷贝 74" class="cls-1" x="1386" y="315" width="4" height="10"/>
  <rect id="矩形_3_拷贝_60" data-name="矩形 3 拷贝 60" class="cls-1" x="901" y="413" width="71" height="4"/>
  <rect id="矩形_3_拷贝_65" data-name="矩形 3 拷贝 65" class="cls-1" x="1142" y="413" width="61" height="4"/>
  <rect id="矩形_3_拷贝_66" data-name="矩形 3 拷贝 66" class="cls-1" x="1250" y="413" width="62" height="4"/>
  <rect id="矩形_3_拷贝_75" data-name="矩形 3 拷贝 75" class="cls-1" x="1310" y="351" width="51" height="4"/>
  <rect id="矩形_4_拷贝_10" data-name="矩形 4 拷贝 10" class="cls-1" x="587" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_10-2" data-name="矩形 4 拷贝 10" class="cls-1" x="587" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_25" data-name="矩形 3 拷贝 25" class="cls-1" x="592" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11-2" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_26" data-name="矩形 3 拷贝 26" class="cls-1" x="780" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12-2" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_27" data-name="矩形 3 拷贝 27" class="cls-1" x="969" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_13" data-name="矩形 4 拷贝 13" class="cls-1" x="1137" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13-2" data-name="矩形 4 拷贝 13" class="cls-1" x="1137" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_28" data-name="矩形 3 拷贝 28" class="cls-1" x="1142" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_14-2" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_29" data-name="矩形 3 拷贝 29" class="cls-1" x="1308" y="326" width="4" height="184"/>
  <g id="组_5" data-name="组 5">
    <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="174" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="174" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,173h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,206l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="201" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="173" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="206" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝" data-name="组 5 拷贝">
    <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="126" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="126" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,125h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-2" d="M610,158l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="153" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="125" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="158" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝_2" data-name="组 5 拷贝 2">
    <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="769" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="174" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="757" y="174" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-2" d="M758,173h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-2" d="M758,206l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="763" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="201" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="178" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="173" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="206" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝_3" data-name="组 5 拷贝 3">
    <rect id="矩形_5_拷贝_17-31" data-name="矩形 5 拷贝 17" class="cls-1" x="769" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-32" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="126" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-33" data-name="矩形 5 拷贝 17" class="cls-1" x="757" y="126" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-34" data-name="矩形 5 拷贝 17" class="cls-2" d="M758,125h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_17-35" data-name="矩形 5 拷贝 17" class="cls-2" d="M758,158l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-36" data-name="矩形 5 拷贝 17" class="cls-1" x="763" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-37" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="153" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-38" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="130" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-39" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="125" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-40" data-name="矩形 5 拷贝 17" class="cls-1" x="728" y="158" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝_4" data-name="组 5 拷贝 4">
    <rect id="矩形_5_拷贝_17-41" data-name="矩形 5 拷贝 17" class="cls-1" x="1157" y="110" width="24" height="1"/>
    <rect id="矩形_5_拷贝_17-42" data-name="矩形 5 拷贝 17" class="cls-1" x="1153" y="151" width="32" height="1"/>
    <rect id="矩形_5_拷贝_17-43" data-name="矩形 5 拷贝 17" class="cls-1" x="1153" y="122" width="32" height="1"/>
    <path id="矩形_5_拷贝_17-44" data-name="矩形 5 拷贝 17" class="cls-2" d="M1152,122v1l34,29v-1Z"/>
    <path id="矩形_5_拷贝_17-45" data-name="矩形 5 拷贝 17" class="cls-2" d="M1185,122l-33,30h1l33-30h-1Z"/>
    <rect id="矩形_5_拷贝_17-46" data-name="矩形 5 拷贝 17" class="cls-1" x="1157" y="116" width="24" height="1"/>
    <rect id="矩形_5_拷贝_17-47" data-name="矩形 5 拷贝 17" class="cls-1" x="1180" y="110" width="1" height="6"/>
    <rect id="矩形_5_拷贝_17-48" data-name="矩形 5 拷贝 17" class="cls-1" x="1157" y="110" width="1" height="6"/>
    <rect id="矩形_5_拷贝_17-49" data-name="矩形 5 拷贝 17" class="cls-1" x="1152" y="122" width="1" height="30"/>
    <rect id="矩形_5_拷贝_17-50" data-name="矩形 5 拷贝 17" class="cls-1" x="1185" y="122" width="1" height="30"/>
  </g>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="467" y="216" width="56" height="4"/>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="467" y="197" width="56" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="467" y="156" width="56" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="466" y="142" width="4" height="31"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="466" y="112" width="4" height="18"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="467" y="188" width="4" height="83"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1144" y="159" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1186" y="159" width="11" height="4"/>
  <g id="组_20" data-name="组 20">
    <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="183" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="187" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="207" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="211" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="191" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="195" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="199" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="203" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="162" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="166" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="153" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="157" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="170" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="174" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="178" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="182" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="556" y="147" width="1" height="71"/>
  </g>
  <g id="组_22" data-name="组 22" class="cls-3">
    <rect id="矩形_5" data-name="矩形 5" class="cls-4" x="275" y="108" width="141" height="157"/>
    <rect id="矩形_5_拷贝_2" data-name="矩形 5 拷贝 2" class="cls-4" x="275" y="325" width="141" height="179"/>
    <rect id="矩形_5_拷贝_3" data-name="矩形 5 拷贝 3" class="cls-4" x="441" y="325" width="141" height="179"/>
    <rect id="矩形_5_拷贝_4" data-name="矩形 5 拷贝 4" class="cls-4" x="606" y="325" width="161" height="179"/>
    <rect id="矩形_7" data-name="矩形 7" class="cls-4" x="789" y="423" width="80" height="81"/>
    <rect id="矩形_7_拷贝_4" data-name="矩形 7 拷贝 4" class="cls-4" x="1152" y="423" width="69" height="81"/>
    <rect id="矩形_7_拷贝_5" data-name="矩形 7 拷贝 5" class="cls-4" x="1234" y="423" width="68" height="81"/>
    <rect id="矩形_7_拷贝_6" data-name="矩形 7 拷贝 6" class="cls-4" x="1318" y="361" width="62" height="143"/>
    <rect id="矩形_7_拷贝" data-name="矩形 7 拷贝" class="cls-4" x="884" y="423" width="80" height="81"/>
    <rect id="矩形_7_拷贝_2" data-name="矩形 7 拷贝 2" class="cls-4" x="980" y="325" width="69" height="179"/>
    <rect id="矩形_7_拷贝_3" data-name="矩形 7 拷贝 3" class="cls-4" x="1067" y="325" width="69" height="179"/>
    <rect id="矩形_5_拷贝" data-name="矩形 5 拷贝" class="cls-4" x="792" y="108" width="268" height="157"/>
    <path id="矩形_6" data-name="矩形 6" class="cls-5" d="M108,121h98V108h47V265H108V121Z"/>
    <path id="矩形_6_拷贝_2" data-name="矩形 6 拷贝 2" class="cls-5" d="M107,467H207v37h45V325H107V467Z"/>
    <path id="矩形_6_拷贝" data-name="矩形 6 拷贝" class="cls-5" d="M1465,127h-92V108h-47V265h139V127Z"/>
  </g>
</svg>

EFO;

                return \show(1, 'OK', $data, 200);
                break;
            case ($floor == 23):
                $data[0] = [
                    'floor' => '23',
                    'phase' => '海创空间大厦二期',
                    'enterprise_id' => '园区管理办公室',
                    'room_number' => 2301,
                    'area' => 1442.1
                ];
                $data['svg'] = <<<EFO
<svg id="边" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1621 620">
<defs>
    <style>
      .cls-1, .cls-2 {
        fill: #585b7a;
      }

      .cls-2 {
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="198" y="481" width="1075" height="6"/>
  <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="213" y="109" width="6" height="19"/>
  <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="1267" y="451" width="6" height="36"/>
  <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="192" y="455" width="6" height="32"/>
  <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="116" y="455" width="76" height="6"/>
  <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1343" y="341" width="6" height="116"/>
  <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="1343" y="122" width="6" height="215"/>
  <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="116" y="122" width="6" height="334"/>
  <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="119" y="122" width="94" height="6"/>
  <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="219" y="109" width="988" height="6"/>
  <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="1271" y="451" width="78" height="6"/>
  <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="1261" y="340" width="84" height="4"/>
  <rect id="矩形_3_拷贝_24" data-name="矩形 3 拷贝 24" class="cls-1" x="1203" y="340" width="29" height="4"/>
  <rect id="矩形_3_拷贝_60" data-name="矩形 3 拷贝 60" class="cls-1" x="1203" y="120" width="146" height="6"/>
  <rect id="矩形_3_拷贝_25" data-name="矩形 3 拷贝 25" class="cls-1" x="1086" y="323" width="117" height="4"/>
  <rect id="矩形_3_拷贝_28" data-name="矩形 3 拷贝 28" class="cls-1" x="935" y="323" width="117" height="4"/>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="768" y="323" width="130" height="4"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="829" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_63" data-name="矩形 3 拷贝 63" class="cls-1" x="977" y="271" width="48" height="4"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="513" y="323" width="184" height="4"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="349" y="323" width="132" height="4"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="264" y="323" width="60" height="4"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="129" y="343" width="147" height="4"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="264" y="269" width="111" height="4"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="122" y="236" width="142" height="4"/>
  <rect id="矩形_3_拷贝_29" data-name="矩形 3 拷贝 29" class="cls-1" x="1048" y="327" width="4" height="154"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="977" y="113" width="4" height="161"/>
  <rect id="矩形_3_拷贝_64" data-name="矩形 3 拷贝 64" class="cls-1" x="1044" y="113" width="4" height="118"/>
  <rect id="矩形_3_拷贝_66" data-name="矩形 3 拷贝 66" class="cls-1" x="1044" y="256" width="4" height="19"/>
  <rect id="矩形_3_拷贝_67" data-name="矩形 3 拷贝 67" class="cls-1" x="1079" y="271" width="16" height="4"/>
  <rect id="矩形_3_拷贝_68" data-name="矩形 3 拷贝 68" class="cls-1" x="1025" y="271" width="34" height="4"/>
  <rect id="矩形_3_拷贝_65" data-name="矩形 3 拷贝 65" class="cls-1" x="1091" y="113" width="4" height="161"/>
  <rect id="矩形_3_拷贝_65-2" data-name="矩形 3 拷贝 65" class="cls-1" x="1146" y="111" width="2" height="118"/>
  <rect id="矩形_3_拷贝_30" data-name="矩形 3 拷贝 30" class="cls-1" x="894" y="327" width="4" height="154"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="731" y="327" width="4" height="154"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="562" y="327" width="4" height="154"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="414" y="327" width="4" height="154"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="272" y="443" width="4" height="38"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="264" y="323" width="4" height="21"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="272" y="343" width="4" height="11"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="264" y="114" width="4" height="30"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="264" y="236" width="4" height="100"/>
  <rect id="矩形_3_拷贝_27" data-name="矩形 3 拷贝 27" class="cls-1" x="1131" y="271" width="72" height="4"/>
  <rect id="矩形_3_拷贝_74" data-name="矩形 3 拷贝 74" class="cls-1" x="1203" y="236" width="142" height="4"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1111" y="226" width="72" height="4"/>
  <rect id="矩形_3_拷贝_26" data-name="矩形 3 拷贝 26" class="cls-1" x="1203" y="115" width="4" height="225"/>
  <rect id="矩形_3_拷贝_75" data-name="矩形 3 拷贝 75" class="cls-1" x="1203" y="109" width="6" height="17"/>
  <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="117" y="446" width="14" height="14"/>
  <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="116" y="122" width="14" height="14"/>
  <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="1335" y="336" width="14" height="14"/>
  <rect id="矩形_4_拷贝_2" data-name="矩形 4 拷贝 2" class="cls-1" x="1043" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="889" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="726" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_9" data-name="矩形 4 拷贝 9" class="cls-1" x="557" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_10" data-name="矩形 4 拷贝 10" class="cls-1" x="409" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_20" data-name="矩形 4 拷贝 20" class="cls-1" x="409" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_21" data-name="矩形 4 拷贝 21" class="cls-1" x="557" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_22" data-name="矩形 4 拷贝 22" class="cls-1" x="726" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_23" data-name="矩形 4 拷贝 23" class="cls-1" x="889" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_24" data-name="矩形 4 拷贝 24" class="cls-1" x="1042" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_25" data-name="矩形 4 拷贝 25" class="cls-1" x="1193" y="318" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="266" y="472" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="264" y="259" width="14" height="14"/>
  <rect id="矩形_4_拷贝_17" data-name="矩形 4 拷贝 17" class="cls-1" x="399" y="270" width="24" height="4"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="259" y="111" width="14" height="14"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="414" y="114" width="4" height="158"/>
  <rect id="矩形_4_拷贝_16" data-name="矩形 4 拷贝 16" class="cls-1" x="409" y="111" width="14" height="14"/>
  <rect id="矩形_4_拷贝_26" data-name="矩形 4 拷贝 26" class="cls-1" x="409" y="259" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13" data-name="矩形 4 拷贝 13" class="cls-1" x="264" y="323" width="14" height="14"/>
  <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1335" y="441" width="14" height="14"/>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="116" y="338" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="116" y="231" width="14" height="14"/>
  <rect id="矩形_3_拷贝_37-2" data-name="矩形 3 拷贝 37" class="cls-1" x="496" y="270" width="127" height="4"/>
  <rect id="矩形_3_拷贝_41-2" data-name="矩形 3 拷贝 41" class="cls-1" x="438" y="270" width="23" height="4"/>
  <rect id="矩形_3_拷贝_38-2" data-name="矩形 3 拷贝 38" class="cls-1" x="684" y="271" width="122" height="4"/>
  <rect id="矩形_3_拷贝_44-2" data-name="矩形 3 拷贝 44" class="cls-1" x="496" y="253" width="4" height="17"/>
  <rect id="矩形_3_拷贝_43-2" data-name="矩形 3 拷贝 43" class="cls-1" x="496" y="112" width="4" height="119"/>
  <rect id="矩形_3_拷贝_45-2" data-name="矩形 3 拷贝 45" class="cls-1" x="561" y="133" width="4" height="137"/>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="619" y="133" width="4" height="15"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="619" y="173" width="4" height="25"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="619" y="224" width="4" height="24"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="619" y="261" width="4" height="9"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="684" y="259" width="4" height="12"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="684" y="223" width="4" height="21"/>
  <rect id="矩形_3_拷贝_58" data-name="矩形 3 拷贝 58" class="cls-1" x="684" y="172" width="4" height="25"/>
  <rect id="矩形_3_拷贝_59" data-name="矩形 3 拷贝 59" class="cls-1" x="684" y="133" width="4" height="15"/>
  <rect id="矩形_3_拷贝_46-2" data-name="矩形 3 拷贝 46" class="cls-1" x="500" y="129" width="123" height="4"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="684" y="129" width="59" height="4"/>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="684" y="184" width="59" height="2"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="684" y="235" width="59" height="2"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="564" y="236" width="59" height="2"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="564" y="185" width="59" height="2"/>
  <rect id="矩形_3_拷贝_36-2" data-name="矩形 3 拷贝 36" class="cls-1" x="741" y="128" width="4" height="143"/>
  <rect id="矩形_4_拷贝_2-2" data-name="矩形 4 拷贝 2" class="cls-1" x="731" y="114" width="14" height="15"/>
  <rect id="矩形_5_拷贝_7" data-name="矩形 5 拷贝 7" class="cls-1" x="611" y="145" width="1" height="32"/>
  <rect id="矩形_5_拷贝_9" data-name="矩形 5 拷贝 9" class="cls-1" x="582" y="145" width="1" height="32"/>
  <path id="矩形_5_拷贝_15" data-name="矩形 5 拷贝 15" class="cls-2" d="M582,144h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_16" data-name="矩形 5 拷贝 16" class="cls-2" d="M582,177l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_11" data-name="矩形 5 拷贝 11" class="cls-1" x="570" y="149" width="1" height="24"/>
  <rect id="矩形_5_拷贝_12" data-name="矩形 5 拷贝 12" class="cls-1" x="576" y="149" width="1" height="24"/>
  <rect id="矩形_5_拷贝_13" data-name="矩形 5 拷贝 13" class="cls-1" x="570" y="172" width="6" height="1"/>
  <rect id="矩形_5_拷贝_14" data-name="矩形 5 拷贝 14" class="cls-1" x="570" y="149" width="6" height="1"/>
  <rect id="矩形_5_拷贝_8" data-name="矩形 5 拷贝 8" class="cls-1" x="582" y="144" width="30" height="1"/>
  <rect id="矩形_5_拷贝_10" data-name="矩形 5 拷贝 10" class="cls-1" x="582" y="177" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="570" y="199" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="611" y="195" width="1" height="32"/>
  <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="582" y="195" width="1" height="32"/>
  <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-2" d="M582,194h1l29,34h-1Z"/>
  <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-2" d="M582,227l30-33v1l-30,33v-1Z"/>
  <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="576" y="199" width="1" height="24"/>
  <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="570" y="222" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="570" y="199" width="6" height="1"/>
  <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="582" y="194" width="30" height="1"/>
  <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="582" y="227" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18" data-name="矩形 5 拷贝 18" class="cls-1" x="694" y="194" width="1" height="32"/>
  <rect id="矩形_5_拷贝_18-2" data-name="矩形 5 拷贝 18" class="cls-1" x="723" y="194" width="1" height="32"/>
  <path id="矩形_5_拷贝_18-3" data-name="矩形 5 拷贝 18" class="cls-2" d="M724,193h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_18-4" data-name="矩形 5 拷贝 18" class="cls-2" d="M724,226l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_18-5" data-name="矩形 5 拷贝 18" class="cls-1" x="735" y="198" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-6" data-name="矩形 5 拷贝 18" class="cls-1" x="729" y="198" width="1" height="24"/>
  <rect id="矩形_5_拷贝_18-7" data-name="矩形 5 拷贝 18" class="cls-1" x="730" y="221" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-8" data-name="矩形 5 拷贝 18" class="cls-1" x="730" y="198" width="6" height="1"/>
  <rect id="矩形_5_拷贝_18-9" data-name="矩形 5 拷贝 18" class="cls-1" x="694" y="193" width="30" height="1"/>
  <rect id="矩形_5_拷贝_18-10" data-name="矩形 5 拷贝 18" class="cls-1" x="694" y="226" width="30" height="1"/>
  <rect id="矩形_5_拷贝_21" data-name="矩形 5 拷贝 21" class="cls-1" x="1054" y="162" width="32" height="1"/>
  <rect id="矩形_5_拷贝_21-2" data-name="矩形 5 拷贝 21" class="cls-1" x="1054" y="133" width="32" height="1"/>
  <path id="矩形_5_拷贝_21-3" data-name="矩形 5 拷贝 21" class="cls-2" d="M1053,133v1l34,29v-1Z"/>
  <path id="矩形_5_拷贝_21-4" data-name="矩形 5 拷贝 21" class="cls-2" d="M1086,133l-33,30h1l33-30h-1Z"/>
  <rect id="矩形_5_拷贝_21-5" data-name="矩形 5 拷贝 21" class="cls-1" x="1058" y="121" width="24" height="1"/>
  <rect id="矩形_5_拷贝_21-6" data-name="矩形 5 拷贝 21" class="cls-1" x="1058" y="127" width="24" height="1"/>
  <rect id="矩形_5_拷贝_21-7" data-name="矩形 5 拷贝 21" class="cls-1" x="1081" y="121" width="1" height="6"/>
  <rect id="矩形_5_拷贝_21-8" data-name="矩形 5 拷贝 21" class="cls-1" x="1058" y="121" width="1" height="6"/>
  <rect id="矩形_5_拷贝_21-9" data-name="矩形 5 拷贝 21" class="cls-1" x="1053" y="133" width="1" height="30"/>
  <rect id="矩形_5_拷贝_21-10" data-name="矩形 5 拷贝 21" class="cls-1" x="1086" y="133" width="1" height="30"/>
  <rect id="矩形_5_拷贝_19" data-name="矩形 5 拷贝 19" class="cls-1" x="694" y="144" width="1" height="32"/>
  <rect id="矩形_5_拷贝_19-2" data-name="矩形 5 拷贝 19" class="cls-1" x="723" y="144" width="1" height="32"/>
  <path id="矩形_5_拷贝_19-3" data-name="矩形 5 拷贝 19" class="cls-2" d="M724,143h-1l-29,34h1Z"/>
  <path id="矩形_5_拷贝_19-4" data-name="矩形 5 拷贝 19" class="cls-2" d="M724,176l-30-33v1l30,33v-1Z"/>
  <rect id="矩形_5_拷贝_19-5" data-name="矩形 5 拷贝 19" class="cls-1" x="735" y="148" width="1" height="24"/>
  <rect id="矩形_5_拷贝_19-6" data-name="矩形 5 拷贝 19" class="cls-1" x="729" y="148" width="1" height="24"/>
  <rect id="矩形_5_拷贝_19-7" data-name="矩形 5 拷贝 19" class="cls-1" x="730" y="171" width="6" height="1"/>
  <rect id="矩形_5_拷贝_19-8" data-name="矩形 5 拷贝 19" class="cls-1" x="730" y="148" width="6" height="1"/>
  <rect id="矩形_5_拷贝_19-9" data-name="矩形 5 拷贝 19" class="cls-1" x="694" y="143" width="30" height="1"/>
  <rect id="矩形_5_拷贝_19-10" data-name="矩形 5 拷贝 19" class="cls-1" x="694" y="176" width="30" height="1"/>
  <rect id="矩形_3_拷贝_52-2" data-name="矩形 3 拷贝 52" class="cls-1" x="444" y="219" width="56" height="4"/>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="444" y="197" width="56" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="444" y="156" width="56" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="443" y="142" width="4" height="31"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="443" y="112" width="4" height="18"/>
  <rect id="矩形_3_拷贝_53-2" data-name="矩形 3 拷贝 53" class="cls-1" x="444" y="188" width="4" height="83"/>
  <rect id="矩形_3_拷贝_69-2" data-name="矩形 3 拷贝 69" class="cls-1" x="1044" y="167" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1084" y="167" width="11" height="4"/>
  <g id="组_20" data-name="组 20">
    <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="191" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="195" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="215" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="219" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="199" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="203" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="207" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="503" y="211" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="170" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="174" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="161" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="165" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="178" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="182" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="186" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="533" y="190" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="530" y="155" width="1" height="71"/>
    <rect id="矩形_5_拷贝_30" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="191" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-2" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="195" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-3" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="215" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-4" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="219" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-5" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="199" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-6" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="203" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-7" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="207" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-8" data-name="矩形 5 拷贝 30" class="cls-1" x="985" y="211" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-9" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="170" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-10" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="174" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-11" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="161" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-12" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="165" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-13" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="178" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-14" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="182" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-15" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="186" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-16" data-name="矩形 5 拷贝 30" class="cls-1" x="1015" y="190" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-17" data-name="矩形 5 拷贝 30" class="cls-1" x="1012" y="155" width="1" height="71"/>
  </g>
</svg>

EFO;

                return \show(1, 'OK', $data, 200);
                break;
            default:
                $model = new \app\admin\model\ParkRoom();
                $data = $model
                    ->where('phase', 'eq', 2)
                    ->where('floor', 'eq', $floor)
                    ->select();
                $data['svg'] = <<<EFO
<svg id="边" xmlns="http://www.w3.org/2000/svg" width="650" height="248" viewBox="0 0 1621 620">
<defs>
    <style>
      .cls-1, .cls-4 {
        fill: #585b7a;
      }

      .cls-2, .cls-3 {
        fill: #54befc;
      }

      .cls-3, .cls-4 {
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <g id="组_6" data-name="组 6">
    <rect id="矩形_1" data-name="矩形 1" class="cls-1" x="199" y="510" width="1180" height="6"/>
    <rect id="矩形_3_拷贝_14" data-name="矩形 3 拷贝 14" class="cls-1" x="192" y="93" width="6" height="19"/>
    <rect id="矩形_3_拷贝_18" data-name="矩形 3 拷贝 18" class="cls-1" x="1373" y="475" width="6" height="41"/>
    <rect id="矩形_3_拷贝_20" data-name="矩形 3 拷贝 20" class="cls-1" x="193" y="475" width="6" height="41"/>
    <rect id="矩形_3_拷贝_21" data-name="矩形 3 拷贝 21" class="cls-1" x="91" y="475" width="102" height="6"/>
    <rect id="矩形_3_拷贝_8" data-name="矩形 3 拷贝 8" class="cls-1" x="1475" y="117" width="6" height="360"/>
    <rect id="矩形_3_拷贝_5" data-name="矩形 3 拷贝 5" class="cls-1" x="91" y="106" width="6" height="370"/>
    <rect id="矩形_3_拷贝_17" data-name="矩形 3 拷贝 17" class="cls-1" x="1382" y="94" width="6" height="24"/>
    <rect id="矩形_3_拷贝_9" data-name="矩形 3 拷贝 9" class="cls-1" x="1387" y="112" width="94" height="6"/>
    <rect id="矩形_3_拷贝_13" data-name="矩形 3 拷贝 13" class="cls-1" x="94" y="106" width="98" height="6"/>
    <rect id="矩形_3_拷贝_11" data-name="矩形 3 拷贝 11" class="cls-1" x="197" y="93" width="1191" height="6"/>
    <rect id="矩形_3_拷贝_7" data-name="矩形 3 拷贝 7" class="cls-1" x="1377" y="475" width="104" height="6"/>
    <rect id="矩形_3_拷贝_23" data-name="矩形 3 拷贝 23" class="cls-1" x="1353" y="315" width="124" height="4"/>
    <rect id="矩形_3_拷贝_30" data-name="矩形 3 拷贝 30" class="cls-1" x="1356" y="270" width="120" height="4"/>
    <rect id="矩形_4_拷贝_4" data-name="矩形 4 拷贝 4" class="cls-1" x="92" y="466" width="14" height="14"/>
    <rect id="矩形_4_拷贝_5" data-name="矩形 4 拷贝 5" class="cls-1" x="91" y="111" width="14" height="14"/>
    <rect id="矩形_4" data-name="矩形 4" class="cls-1" x="1467" y="257" width="14" height="14"/>
    <rect id="矩形_4_拷贝" data-name="矩形 4 拷贝" class="cls-1" x="1467" y="112" width="14" height="14"/>
    <rect id="矩形_4_拷贝-2" data-name="矩形 4 拷贝" class="cls-1" x="1466" y="319" width="14" height="14"/>
    <rect id="矩形_4_拷贝_3" data-name="矩形 4 拷贝 3" class="cls-1" x="1467" y="465" width="14" height="14"/>
  </g>
  <rect id="矩形_4_拷贝_6" data-name="矩形 4 拷贝 6" class="cls-1" x="91" y="318" width="14" height="14"/>
  <rect id="矩形_4_拷贝_15" data-name="矩形 4 拷贝 15" class="cls-1" x="91" y="257" width="14" height="14"/>
  <rect id="矩形_3_拷贝_4" data-name="矩形 3 拷贝 4" class="cls-1" x="93" y="315" width="132" height="4"/>
  <rect id="矩形_3_拷贝_6" data-name="矩形 3 拷贝 6" class="cls-1" x="302" y="315" width="134" height="4"/>
  <rect id="矩形_3_拷贝_38" data-name="矩形 3 拷贝 38" class="cls-1" x="813" y="271" width="225" height="4"/>
  <rect id="矩形_3_拷贝_55" data-name="矩形 3 拷贝 55" class="cls-1" x="306" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_56" data-name="矩形 3 拷贝 56" class="cls-1" x="94" y="271" width="130" height="4"/>
  <rect id="矩形_3_拷贝_57" data-name="矩形 3 拷贝 57" class="cls-1" x="251" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_10" data-name="矩形 3 拷贝 10" class="cls-1" x="455" y="315" width="146" height="4"/>
  <rect id="矩形_3_拷贝_12" data-name="矩形 3 拷贝 12" class="cls-1" x="634" y="315" width="155" height="4"/>
  <rect id="矩形_3_拷贝_15" data-name="矩形 3 拷贝 15" class="cls-1" x="821" y="315" width="157" height="4"/>
  <rect id="矩形_3_拷贝_16" data-name="矩形 3 拷贝 16" class="cls-1" x="1002" y="315" width="114" height="4"/>
  <rect id="矩形_3_拷贝_19" data-name="矩形 3 拷贝 19" class="cls-1" x="1182" y="315" width="135" height="4"/>
  <g id="组_4" data-name="组 4">
    <rect id="矩形_4_拷贝_7" data-name="矩形 4 拷贝 7" class="cls-1" x="256" y="319" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8" data-name="矩形 4 拷贝 8" class="cls-1" x="256" y="466" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22" data-name="矩形 3 拷贝 22" class="cls-1" x="261" y="326" width="4" height="184"/>
  </g>
  <g id="组_4_拷贝" data-name="组 4 拷贝">
    <rect id="矩形_4_拷贝_7-2" data-name="矩形 4 拷贝 7" class="cls-1" x="257" y="257" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8-2" data-name="矩形 4 拷贝 8" class="cls-1" x="257" y="111" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22-2" data-name="矩形 3 拷贝 22" class="cls-1" x="262" y="98" width="4" height="166"/>
  </g>
  <g id="组_4_拷贝_2" data-name="组 4 拷贝 2">
    <rect id="矩形_4_拷贝_7-3" data-name="矩形 4 拷贝 7" class="cls-1" x="422" y="257" width="14" height="14"/>
    <rect id="矩形_4_拷贝_8-3" data-name="矩形 4 拷贝 8" class="cls-1" x="422" y="111" width="14" height="14"/>
    <rect id="矩形_3_拷贝_22-3" data-name="矩形 3 拷贝 22" class="cls-1" x="427" y="98" width="4" height="166"/>
  </g>
  <rect id="room_11" data-name="矩形 5" class="cls-2 room" data-room="11" x="275" y="106" width="141" height="157"/>
  <rect id="room_07" data-name="矩形 5 拷贝 2" class="cls-2 room" data-room="07" x="275" y="325" width="141" height="179"/>
  <rect id="room_06" data-name="矩形 5 拷贝 3" class="cls-2 room" data-room="06" x="441" y="325" width="141" height="179"/>
  <rect id="room_05" data-name="矩形 5 拷贝 4" class="cls-2 room" data-room="05" x="607" y="325" width="161" height="179"/>
  <rect id="room_04" data-name="矩形 5 拷贝 5" class="cls-2 room" data-room="04" x="796" y="325" width="161" height="179"/>
  <rect id="room_03" data-name="矩形 5 拷贝 6" class="cls-2 room" data-room="03" x="985" y="325" width="146" height="179"/>
  <rect id="room_02" data-name="矩形 5 拷贝 7" class="cls-2 room" data-room="02" x="1154" y="325" width="146" height="179"/>
  <rect id="room_10" data-name="矩形 5 拷贝" class="cls-2 room" data-room="10" x="792" y="106" width="268" height="157"/>
  <path id="room_12" data-name="矩形 6" class="cls-3 room" data-room="12" d="M108,119h98V106h47V263H108V119Z"/>
  <path id="room_08" data-name="矩形 6 拷贝 2" class="cls-3 room" data-room="08" d="M107,467H207v37h45V325H107V467Z"/>
  <path id="room_09" data-name="矩形 6 拷贝" class="cls-3 room" data-room="09" d="M1465,125h-92V106h-47V263h139V125Z"/>
  <path id="room_01" data-name="矩形 6 拷贝 3" class="cls-3 room" data-room="01" d="M1464,468h-97v34h-47V325h144V468Z"/>
  <rect id="矩形_4_拷贝_9" data-name="矩形 4 拷贝 9" class="cls-1" x="422" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_9-2" data-name="矩形 4 拷贝 9" class="cls-1" x="422" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_24" data-name="矩形 3 拷贝 24" class="cls-1" x="427" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_10" data-name="矩形 4 拷贝 10" class="cls-1" x="587" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_10-2" data-name="矩形 4 拷贝 10" class="cls-1" x="587" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_25" data-name="矩形 3 拷贝 25" class="cls-1" x="592" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_11" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_11-2" data-name="矩形 4 拷贝 11" class="cls-1" x="775" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_26" data-name="矩形 3 拷贝 26" class="cls-1" x="780" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_12" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_12-2" data-name="矩形 4 拷贝 12" class="cls-1" x="964" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_27" data-name="矩形 3 拷贝 27" class="cls-1" x="969" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_13" data-name="矩形 4 拷贝 13" class="cls-1" x="1137" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_13-2" data-name="矩形 4 拷贝 13" class="cls-1" x="1137" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_28" data-name="矩形 3 拷贝 28" class="cls-1" x="1142" y="326" width="4" height="184"/>
  <rect id="矩形_4_拷贝_14" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="319" width="14" height="14"/>
  <rect id="矩形_4_拷贝_14-2" data-name="矩形 4 拷贝 14" class="cls-1" x="1303" y="466" width="14" height="14"/>
  <rect id="矩形_3_拷贝_29" data-name="矩形 3 拷贝 29" class="cls-1" x="1308" y="326" width="4" height="184"/>
  <rect id="矩形_3_拷贝_40" data-name="矩形 3 拷贝 40" class="cls-1" x="720" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_41" data-name="矩形 3 拷贝 41" class="cls-1" x="720" y="112" width="64" height="4"/>
  <rect id="矩形_3_拷贝_42" data-name="矩形 3 拷贝 42" class="cls-1" x="720" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_43" data-name="矩形 3 拷贝 43" class="cls-1" x="720" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_39" data-name="矩形 3 拷贝 39" class="cls-1" x="780" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_44" data-name="矩形 3 拷贝 44" class="cls-1" x="720" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_45" data-name="矩形 3 拷贝 45" class="cls-1" x="720" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_46" data-name="矩形 3 拷贝 46" class="cls-1" x="720" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_47" data-name="矩形 3 拷贝 47" class="cls-1" x="720" y="246" width="4" height="29"/>
  <rect id="矩形_3_拷贝_48" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="271" width="64" height="4"/>
  <rect id="矩形_3_拷贝_51" data-name="矩形 3 拷贝 51" class="cls-1" x="507" y="271" width="85" height="4"/>
  <rect id="矩形_3_拷贝_52" data-name="矩形 3 拷贝 52" class="cls-1" x="467" y="211" width="56" height="4"/>
  <rect id="矩形_3_拷贝_54" data-name="矩形 3 拷贝 54" class="cls-1" x="455" y="271" width="26" height="4"/>
  <rect id="矩形_3_拷贝_53" data-name="矩形 3 拷贝 53" class="cls-1" x="467" y="187" width="4" height="84"/>
  <rect id="矩形_3_拷贝_48-2" data-name="矩形 3 拷贝 48" class="cls-1" x="467" y="112" width="187" height="4"/>
  <rect id="矩形_3_拷贝_48-3" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="165" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-4" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="211" width="64" height="2"/>
  <rect id="矩形_3_拷贝_48-5" data-name="矩形 3 拷贝 48" class="cls-1" x="590" y="99" width="4" height="174"/>
  <rect id="矩形_3_拷贝_49" data-name="矩形 3 拷贝 49" class="cls-1" x="519" y="115" width="4" height="112"/>
  <rect id="矩形_3_拷贝_48-6" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="112" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-7" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="154" width="4" height="24"/>
  <rect id="矩形_3_拷贝_48-8" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="200" width="4" height="34"/>
  <rect id="矩形_3_拷贝_50" data-name="矩形 3 拷贝 50" class="cls-1" x="519" y="255" width="4" height="20"/>
  <rect id="矩形_3_拷贝_48-9" data-name="矩形 3 拷贝 48" class="cls-1" x="650" y="246" width="4" height="29"/>
  <g id="组_5" data-name="组 5">
    <rect id="矩形_5_拷贝_17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-2" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="174" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-3" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="174" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-4" data-name="矩形 5 拷贝 17" class="cls-4" d="M610,173h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-5" data-name="矩形 5 拷贝 17" class="cls-4" d="M610,206l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-6" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-7" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="201" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-8" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="178" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-9" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="173" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-10" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="206" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝" data-name="组 5 拷贝">
    <rect id="矩形_5_拷贝_17-11" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-12" data-name="矩形 5 拷贝 17" class="cls-1" x="639" y="126" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-13" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="126" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-14" data-name="矩形 5 拷贝 17" class="cls-4" d="M610,125h1l29,34h-1Z"/>
    <path id="矩形_5_拷贝_17-15" data-name="矩形 5 拷贝 17" class="cls-4" d="M610,158l30-33v1l-30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-16" data-name="矩形 5 拷贝 17" class="cls-1" x="604" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-17" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="153" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-18" data-name="矩形 5 拷贝 17" class="cls-1" x="598" y="130" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-19" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="125" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-20" data-name="矩形 5 拷贝 17" class="cls-1" x="610" y="158" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝_2" data-name="组 5 拷贝 2">
    <rect id="矩形_5_拷贝_17-21" data-name="矩形 5 拷贝 17" class="cls-1" x="770" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-22" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="174" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-23" data-name="矩形 5 拷贝 17" class="cls-1" x="758" y="174" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-24" data-name="矩形 5 拷贝 17" class="cls-4" d="M759,173h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_17-25" data-name="矩形 5 拷贝 17" class="cls-4" d="M759,206l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-26" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="178" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-27" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="201" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-28" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="178" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-29" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="173" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-30" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="206" width="30" height="1"/>
  </g>
  <g id="组_5_拷贝_3" data-name="组 5 拷贝 3">
    <rect id="矩形_5_拷贝_17-31" data-name="矩形 5 拷贝 17" class="cls-1" x="770" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-32" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="126" width="1" height="32"/>
    <rect id="矩形_5_拷贝_17-33" data-name="矩形 5 拷贝 17" class="cls-1" x="758" y="126" width="1" height="32"/>
    <path id="矩形_5_拷贝_17-34" data-name="矩形 5 拷贝 17" class="cls-4" d="M759,125h-1l-29,34h1Z"/>
    <path id="矩形_5_拷贝_17-35" data-name="矩形 5 拷贝 17" class="cls-4" d="M759,158l-30-33v1l30,33v-1Z"/>
    <rect id="矩形_5_拷贝_17-36" data-name="矩形 5 拷贝 17" class="cls-1" x="764" y="130" width="1" height="24"/>
    <rect id="矩形_5_拷贝_17-37" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="153" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-38" data-name="矩形 5 拷贝 17" class="cls-1" x="765" y="130" width="6" height="1"/>
    <rect id="矩形_5_拷贝_17-39" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="125" width="30" height="1"/>
    <rect id="矩形_5_拷贝_17-40" data-name="矩形 5 拷贝 17" class="cls-1" x="729" y="158" width="30" height="1"/>
  </g>
  <rect id="矩形_3_拷贝_31" data-name="矩形 3 拷贝 31" class="cls-1" x="1237" y="271" width="83" height="4"/>
  <rect id="矩形_3_拷贝_35" data-name="矩形 3 拷贝 35" class="cls-1" x="1180" y="271" width="18" height="4"/>
  <rect id="矩形_3_拷贝_36" data-name="矩形 3 拷贝 36" class="cls-1" x="1068" y="271" width="79" height="4"/>
  <rect id="矩形_3_拷贝_37" data-name="矩形 3 拷贝 37" class="cls-1" x="1143" y="257" width="4" height="18"/>
  <rect id="矩形_3_拷贝_61" data-name="矩形 3 拷贝 61" class="cls-1" x="1216" y="216" width="76" height="4"/>
  <rect id="矩形_3_拷贝_62" data-name="矩形 3 拷贝 62" class="cls-1" x="1251" y="94" width="2" height="124"/>
  <rect id="矩形_3_拷贝_22-4" data-name="矩形 3 拷贝 22" class="cls-1" x="1311" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_32" data-name="矩形 3 拷贝 32" class="cls-1" x="1194" y="97" width="4" height="178"/>
  <rect id="矩形_3_拷贝_33" data-name="矩形 3 拷贝 33" class="cls-1" x="1068" y="97" width="4" height="174"/>
  <rect id="矩形_3_拷贝_34" data-name="矩形 3 拷贝 34" class="cls-1" x="1143" y="97" width="4" height="129"/>
  <rect id="矩形_4-2" data-name="矩形 4" class="cls-1" x="1306" y="257" width="14" height="14"/>
  <rect id="矩形_4_拷贝-3" data-name="矩形 4 拷贝" class="cls-1" x="1306" y="111" width="14" height="14"/>
  <rect id="矩形_5_拷贝_17-41" data-name="矩形 5 拷贝 17" class="cls-1" x="1158" y="110" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-42" data-name="矩形 5 拷贝 17" class="cls-1" x="1154" y="151" width="32" height="1"/>
  <rect id="矩形_5_拷贝_17-43" data-name="矩形 5 拷贝 17" class="cls-1" x="1154" y="122" width="32" height="1"/>
  <path id="矩形_5_拷贝_17-44" data-name="矩形 5 拷贝 17" class="cls-4" d="M1153,122v1l34,29v-1Z"/>
  <path id="矩形_5_拷贝_17-45" data-name="矩形 5 拷贝 17" class="cls-4" d="M1186,122l-33,30h1l33-30h-1Z"/>
  <rect id="矩形_5_拷贝_17-46" data-name="矩形 5 拷贝 17" class="cls-1" x="1158" y="116" width="24" height="1"/>
  <rect id="矩形_5_拷贝_17-47" data-name="矩形 5 拷贝 17" class="cls-1" x="1181" y="110" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-48" data-name="矩形 5 拷贝 17" class="cls-1" x="1158" y="110" width="1" height="6"/>
  <rect id="矩形_5_拷贝_17-49" data-name="矩形 5 拷贝 17" class="cls-1" x="1153" y="122" width="1" height="30"/>
  <rect id="矩形_5_拷贝_17-50" data-name="矩形 5 拷贝 17" class="cls-1" x="1186" y="122" width="1" height="30"/>
  <rect id="矩形_3_拷贝_70" data-name="矩形 3 拷贝 70" class="cls-1" x="468" y="193" width="54" height="4"/>
  <rect id="矩形_3_拷贝_71" data-name="矩形 3 拷贝 71" class="cls-1" x="467" y="153" width="54" height="4"/>
  <rect id="矩形_3_拷贝_72" data-name="矩形 3 拷贝 72" class="cls-1" x="467" y="146" width="4" height="18"/>
  <rect id="矩形_3_拷贝_73" data-name="矩形 3 拷贝 73" class="cls-1" x="467" y="115" width="4" height="10"/>
  <rect id="矩形_3_拷贝_69" data-name="矩形 3 拷贝 69" class="cls-1" x="1144" y="159" width="11" height="4"/>
  <rect id="矩形_3_拷贝_76" data-name="矩形 3 拷贝 76" class="cls-1" x="1186" y="159" width="11" height="4"/>
  <g id="组_20" data-name="组 20">
    <rect id="矩形_5_拷贝_29" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="183" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-2" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="187" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-3" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="207" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-4" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="211" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-5" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="191" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-6" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="195" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-7" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="199" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-8" data-name="矩形 5 拷贝 29" class="cls-1" x="529" y="203" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-9" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="162" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-10" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="166" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-11" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="153" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-12" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="157" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-13" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="170" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-14" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="174" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-15" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="178" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-16" data-name="矩形 5 拷贝 29" class="cls-1" x="559" y="182" width="25" height="1"/>
    <rect id="矩形_5_拷贝_29-17" data-name="矩形 5 拷贝 29" class="cls-1" x="556" y="147" width="1" height="71"/>
    <rect id="矩形_5_拷贝_30" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="183" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-2" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="187" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-3" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="207" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-4" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="211" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-5" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="191" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-6" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="195" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-7" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="199" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-8" data-name="矩形 5 拷贝 30" class="cls-1" x="1081" y="203" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-9" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="162" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-10" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="166" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-11" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="153" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-12" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="157" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-13" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="170" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-14" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="174" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-15" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="178" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-16" data-name="矩形 5 拷贝 30" class="cls-1" x="1111" y="182" width="25" height="1"/>
    <rect id="矩形_5_拷贝_30-17" data-name="矩形 5 拷贝 30" class="cls-1" x="1108" y="147" width="1" height="71"/>
  </g>
</svg>

EFO;

                return \show(1, 'OK', $data, 200);
                break;
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 每间房的详情
     */
    public function room_info()
    {
        $room_id = \input('room_id', 501);
        $data = Db::name('ParkRoom pr')
            ->join('EnterpriseList el', 'pr.enterprise_id=el.id', 'LEFT')
            ->where('phase', 2)
            ->where('room_number', $room_id)
            ->field('phase,floor,room_number,area,enterprise_id')
            ->select();
        foreach ($data as $k=>$v) {
            $data[$k]['phase']='海创空间大厦二期';
            if (!empty($v['enterprise_id'])) {
                $enterprise_name = Db::name('EnterpriseList')->where('id', $v['enterprise_id'])->value('enterprise_list_name');
                $data[$k]['enterprise_id']=$enterprise_name;
            }
        }
        if (empty($data)) {
            return \show(1, 'OK', '请输入正确的房间号', 200);
        } else {
            return \show(1, 'OK', $data, 200);
        }
    }
}