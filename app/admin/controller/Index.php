<?php

namespace app\admin\controller;

use think\Db;
use think\Cache;
use think\helper\Time;
use app\admin\model\News as NewsModel;
use app\admin\model\MemberList;

class Index extends Base
{
    /**
     * 后台首页
     */
    public function index()
    {
        //已租房源
        $rented_room_number = Db::name('ParkRoom')->where('status', 'eq', 1)->count();
        $this->assign('rented_room_number', $rented_room_number);

        //入驻企业数
        $enterprise_number = Db::name('EnterpriseList')->count();
        $this->assign('enterprise_number', $enterprise_number);

        //注册用户数
        $user_number = Db::name('MemberList')->count();
        $this->assign('user_number', $user_number);

        //待处理会议室预定
        $meeting_room_appoint = Db::name('ServiceMeetingroomAppoint')->where('status', 0)->count();
        $this->assign('meeting_room_appoint', $meeting_room_appoint);

        //待处理物业报修
        $to_repair_number = Db::name('ServiceRepair')->where('status', 'in',[0,3])->count();
        $this->assign('to_repair_number', $to_repair_number);

        //待处理投诉
        $to_complains_number = Db::name('ServiceComplains')->where('status', 0)->count();
        $this->assign('to_complains_number', $to_complains_number);

        //发布文章数
        $article_number = Db::name('News')->where('news_columnid', 'in', [1, 2])->count();
        $this->assign('article_number', $article_number);

        //发布活动数量
        $activity_number = Db::name('News')->where('news_columnid', 'eq', 3)->count();
        $this->assign('activity_number', $activity_number);

        //发布公告数量
        $announcement_number = Db::name('Announcement')->count();
        $this->assign('announcement_number', $announcement_number);

        //论坛帖子总数
        $post_all = Db::name('News')->where('news_columnid', 'eq', 4)->where('news_back',1)->count();
        $this->assign('post_all', $post_all);

        //待审核帖子数量
        $post_to_check = Db::name('News')->where('news_columnid', 'eq', 4)->where('news_back',1)->where('news_open', 0)->count();
        $this->assign('post_to_check', $post_to_check);

        //发帖成功数量
        $post_ok = Db::name('News')->where('news_columnid', 'eq', 4)->where('news_back',1)->where('news_open', 1)->count();
        $this->assign('post_ok', $post_ok);

        //房源总数
        $room_all = Db::name('ParkRoom')->count();
        $this->assign('room_all',$room_all);
        
        //未租房源
        $room_0 = Db::name('ParkRoom')->where('status',0)->count();
        $this->assign('room_0',$room_0);

        //已售房源
        $room_2 = Db::name('ParkRoom')->where('status',2)->count();
        $this->assign('room_2',$room_2);

        //已定房源
        $room_3 = Db::name('ParkRoom')->where('status',3)->count();
        $this->assign('room_3',$room_3);

        //自留房源
        $room_4 = Db::name('ParkRoom')->where('status',4)->count();
        $this->assign('room_4',$room_4);

        //代缴费账单
        $bill0 = Db::name('EnterpriseBillList')->where('status','eq',0)->count();
        $this->assign('bill0',$bill0);

        //代开票账单
        $bill1 = Db::name('EnterpriseBillList')->where('status','eq',1)->count();
        $this->assign('bill1',$bill1);

        //已完成账单
        $bill2 = Db::name('EnterpriseBillList')->where('status','eq',2)->count();
        $this->assign('bill2',$bill2);


        //浏览器信息
        $broswerinfo = \getBroswer();
        $isChrome = \stristr($broswerinfo, 'Chrome');
        $this->assign('isChrome', $isChrome);
        //渲染模板
        return $this->fetch();
    }

    /**
     * 后台多语言切换
     */
    public function lang()
    {
        if (!request()->isAjax()) {
            $this->error('提交方式不正确');
        } else {
            $lang = input('lang_s');
            session('login_http_referer', $_SERVER["HTTP_REFERER"]);
            switch ($lang) {
                case 'cn':
                    cookie('think_var', 'zh-cn');
                    break;
                case 'en':
                    cookie('think_var', 'en-us');
                    break;
                //其它语言
                default:
                    cookie('think_var', 'zh-cn');
            }
            Cache::clear();
            $this->success('切换成功', session('login_http_referer'));
        }
    }
}