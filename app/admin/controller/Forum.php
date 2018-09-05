<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 13:56
 */

namespace app\admin\controller;

use think\Db;
use app\admin\model\News as NewsModel;
/**
 * Class Forum
 * @package app\admin\controller
 * 论坛社区管理控制器
 */
class Forum extends Base
{

    /**
     *论坛总览
     */
    public function index()
    {

    }

    /**
     *帖子列表
     */
    public function post_list()
    {
        $keytype=input('keytype','news_title');
        $key=input('key');
        $news_l=input('news_l');
        $opentype_check=input('opentype_check','');
        $news_columnid=input('news_columnid','');
        $diyflag=input('diyflag','');
        //查询：时间格式过滤 获取格式 2015-11-12 - 2015-11-18
        $sldate=input('reservation','');
        $arr = explode(" - ",$sldate);
        if(count($arr)==2){
            $arrdateone=strtotime($arr[0]);
            $arrdatetwo=strtotime($arr[1].' 23:55:55');
            $map['news_time'] = array(array('egt',$arrdateone),array('elt',$arrdatetwo),'AND');
        }
        //map架构查询条件数组
        $map['news_back']= 0;
        if(!empty($key)){
            if($keytype=='news_title'){
                $map[$keytype]= array('like',"%".$key."%");
            }elseif($keytype=='news_author'){
                $map['member_list_username']= array('like',"%".$key."%");
            }else{
                $map[$keytype]= $key;
            }
        }
        if ($opentype_check!=''){
            $map['news_open']= array('eq',$opentype_check);
        }
        if (!empty($news_l)){
            $map['news_l']= array('eq',$news_l);
        }
        if(!config('lang_switch_on')){
            $map['news_l']=  $this->lang;
        }
        if ($news_columnid!=''){
            $ids=get_menu_byid($news_columnid,1,2);
            $map['news_columnid']= array('in',implode(",", $ids));
        }
        $where=$diyflag?"FIND_IN_SET('$diyflag',news_flag)":'';
        $news_model=new NewsModel;
        $news=$news_model->alias("a")->field('a.*,b.*,c.menu_name')
            ->join(config('database.prefix').'member_list b','a.news_auto =b.member_list_id')
            ->join(config('database.prefix').'menu c','a.news_columnid =c.id')
            ->where($map)
            ->where('news_columnid','eq',4)     //只展示论坛的文章
            ->where($where)
            ->order('news_time desc')
            ->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
        $show = $news->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
        $this->assign('page',$show);
        //文章属性数据
        $diyflag_list=Db::name('diyflag')->select();
        $this->assign('diyflag',$diyflag_list);
        //栏目数据
        $menu_text=menu_text($this->lang);
        $this->assign('menu',$menu_text);
        $this->assign('opentype_check',$opentype_check);
        $this->assign('news_columnid',$news_columnid);
        $this->assign('keytype',$keytype);
        $this->assign('keyy',$key);
        $this->assign('news_l',$news_l);
        $this->assign('sldate',$sldate);
        $this->assign('diyflag_check',$diyflag);

        $this->assign('news',$news);
        if(request()->isAjax()){
            return $this->fetch('ajax_post_list');
        }else{
            return $this->fetch();
        }
    }

    /**
     *管理员发帖页面
     */
    public function post_do()
    {

    }

    /**
     *执行添加操作
     */
    public function post_rundo()
    {

    }

    /**
     *修改帖子状态
     */
    public function post_status()
    {

    }

    /**
     *置顶帖子
     */
    public function post_top()
    {

    }

    /**
     *删除帖子
     */
    public function post_delete()
    {

    }
}