<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/9/5
 * Time: 11:33
 */

namespace app\api\controller\v1;

use app\api\controller\AuthBase;
use think\Db;

/**
 * Class Center
 * @package app\api\controller\v1
 * 个人中心
 */
class Center extends AuthBase
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回个人基本信息
     */
    public function index()
    {
//        $token = '0SUSXfUEBtfO0j0KuwYWmQKUvmSexitO8YJWIHgG4Be3Ne3ojqCMXP5ohG1OaSJl';
//        $user_id=\getUserIdByToken($token);
        $user_id = \input('user_id');
        $user_info = \model('MemberList')->getMemberInfoById($user_id);
        return \show(1, 'OK', $user_info, 200);
    }

    /**
     * @return \think\response\Json
     * 修改用户名
     */
    public function update_username()
    {
        if (\request()->isPost()) {
            $user_id = \input('user_id');
            $new_username = \input('user_name');
            $count_username = Db::name('MemberList')
                ->where('member_list_username', 'eq', $new_username)
                ->count();
            if ($count_username > 0) {
                return \show('0', '改昵称已被占用');
            } else {
                $res = Db::name('MemberList')
                    ->where('member_list_id', 'eq', $user_id)
                    ->setField('member_list_username', \trim($new_username));
                if ($res) {
                    return \show('1', '修改成功');
                } else {
                    return \show('0', '修改失败');
                }
            }
        } else {
            return \show(0, '提交方式不正确');
        }

    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 更新手机号
     */
    public function update_phone()
    {
        if (\request()->isPost()) {
            $user_id = \input('user_id');
            $new_phone = \input('phone');
            $count_phone = Db::name('MemberList')
                ->where('member_list_tel', 'eq', $new_phone)
                ->count();
            if ($count_phone > 0) {
                return \show('0', '手机号已存在');
            } else {
                $res = \checksms($new_phone, 3, \input('verify'));
                if (!$res) {
                    return \show('0', '验证码错误');
                } else {
                    $rst = Db::name('MemberList')
                        ->where('member_list_id', 'eq', $user_id)
                        ->setField('member_list_tel', $new_phone);
                    if ($rst) {
                        \show('1', '修改成功');
                    } else {
                        \show(0, '修改失败');
                    }
                }
            }
        } else {
            return \show(0, '提交方式不正确');
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 设置密码
     * 不管是重置密码,修改密码都是手机号+验证码,不需要验证旧密码
     */
    public function setpwd()
    {
        $user_id = \input('user_id');
        $phone = \input('phone');
        $verify = \input('verify');
        $res = \checksms($phone, 3, $verify);
        if (!$res) {
            return \show(0, '验证码错误');
        } else {
            $salt = random(10);
            $new_pwd = \encrypt_password(\input('password'), $salt);
            $rst = Db::name('MemberList')
                ->where('member_list_id', 'eq', $user_id)
                ->setField(['member_list_pwd' => $new_pwd, 'member_list_salt' => $salt]);
            if ($rst) {
                return \show(1, '修改成功');
            } else {
                return \show(0, '修改失败');
            }
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 绑定企业
     */
    public function bind_enterprise()
    {
        if (!\request()->isPost()) {
            return \show(0, '提交方式不正确');
        } else {
            $user_id = \input('user_id');
            $slqdata['member_list_enterprise'] = \input('enterprise_code');
            $code_count = Db::name('EnterpriseList')->where('enterprise_list_code', 'eq', \trim(\input('enterprise_code')))->count();
            if ($code_count < 1)
                return \show(0, '企业码不正确', '', 201);
            $slqdata['member_list_nickname'] = \input('realname');
            $slqdata['member_list_department'] = \input('department');
            if (!$user_id || !$slqdata['member_list_enterprise'] || !$slqdata['member_list_nickname'] || !$slqdata['member_list_department']) {
                return \show(0, '信息不完整');
            } else {
                $enterpriseInfo = \getEnterpriseBasicInfoByCode(\input('enterprise_code'));
                $slqdata['member_list_enterprise'] = $enterpriseInfo['id'];
                $rst = \model('MemberList')->save($slqdata, ['member_list_id' => $user_id]);
                $info = \model('MemberList')
                    ->where('member_list_id', 'eq', $user_id)
                    ->field('member_list_id,member_list_enterprise,member_list_nickname,member_list_department')
                    ->find();
                if ($rst) {
                    return \show(1, '绑定成功', $info, 200);
                } else {
                    return \show(0, '绑定失败');
                }
            }
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取已参加的活动
     */
    public function my_activity()
    {
        $user_id = \input('user_id');
        $page = \input('page', 1);
        $map = [
            'aa.user_id' => $user_id,
        ];
        $field = 'id,activity_id,user_id,news_title,FROM_UNIXTIME(news_hold_time) as hold_time,status';
        $list = Db::name('ActivityApply aa')
            ->join('News n', 'aa.activity_id=n.n_id')
            ->where($map)
            ->field($field)
            ->order('create_time desc')
            ->page($page, 3)
            ->select();
        return \show('1', "ok", $list, 200);
    }


    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回个人发帖列表
     */
    public function my_forum()
    {
        $page = \input('page', 1);
        $user_id = \input('user_id');
        $c_id = 4;
        $model = new \app\api\model\News();
        $data = $model->getNewsListByUserId($page, $user_id, $c_id);
        return \show(1, 'Ok', $data, 200);
    }

    /**
     *app端用户发帖
     */
    public function add_forum()
    {
        $base64img = \input('image');
        if (!empty($base64img)) {
            $base64img = \json_decode($base64img);
            //图片上传后返回完整地址的数组,根据原本数据规则,需要进行分割拼接处理.
            $pic_url = $this->img_upload($base64img);
            $dir = '/data/upload/' . \date('Y-m-d') . '/';
            foreach ($pic_url as &$v) {
                $v = $dir . \cut_str($v, '/', -1);
            }
            $pic_url = \array_filter($pic_url); //得到切割为相对路径的数组
            $news_img = $pic_url[0];
            $pic_url = \implode(',', $pic_url); //将数组转为字符串后入库
            $news_pic_type = 2;
        } else {
            $pic_url = '';
            $news_pic_type = 1;
        }
        $sqldata = [
            'news_title' => \input('title'),
            'news_columnid' => 4,
            'news_auto' => \input('user_id'),
            'news_content' => \input('content'),
            'news_img' => $news_img,    //封面图片路径
            'news_pic_type' => $news_pic_type,
            'news_pic_allurl' => $pic_url,//多图路径
            'news_time' => \time(),
        ];
        $res = \model('News')->allowField(true)->save($sqldata);
        if ($res) {
            return \show('1', 'OK', $res, 200);
        } else {
            return \show(0, 'Fail', '', 200);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 删除自己发布的某文章
     */
    public function dele_forum()
    {
        $n_id = \input('n_id');
        $u_id = \input('user_id');
        $p_id = Db::name('News')->where('n_id', 'eq', $n_id)->value('news_auto');
        if ($u_id != $p_id) {
            return \show(0, '没有权限');
        } else {
            $res = Db::name('News')
                ->where('n_id', 'eq', $n_id)
                ->where('news_auto', 'eq', $u_id)
                ->delete();
            if ($res) {
                return \show(1, '删除成功', '', 200);
            } else {
                return \show('0', '删除失败');
            }
        }
    }

    /**
     * @return \think\response\Json
     * @throws \Exception
     * 设置头像
     */
    public function avatar()
    {
        $user_id = \input('user_id');
        $base64img = \input('image/a');
        if (empty($user_id) || empty($base64img)) {
            return \show(0, '数据不完整', '', 201);
        }
        if (!empty($base64img)) {
            //得到完整的头像路径
            $pic_url = $this->img_upload($base64img);
            //得到的是数组,需要转为字符串进行分割
            $pic_url = \implode('', $pic_url);
            //因为数据库存的只是文件名,所以截取文件名进行保存
            $sql_pic_url = \cut_str($pic_url, '/', -1);
        } else {
            $pic_url = '';
        }
        //因为上传文件的文件夹和头像文件夹不是用一个,所以需要移动到头像专属文件夹.
        $domain = \request()->domain();
        $table_change = array($domain => '');
        $url1 = ROOT_PATH . \strtr($pic_url, $table_change);
        $newname = ROOT_PATH . 'data/upload/avatar/' . $sql_pic_url;
        //移动图片
        \rename($url1, $newname);
        $res = \model('MemberList')
            ->where('member_list_id', 'eq', $user_id)
            ->setField('member_list_headpic', $sql_pic_url);
        //拼接好前端需要的路径
        $return_pic_url = \request()->domain() . '/' . 'data/upload/avatar/' . $sql_pic_url;
        if ($res) {
            return \show(1, '修改成功', $return_pic_url, 200);
        } else {
            return \show('0', '修改失败', '', 201);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 我的会议室预约列表
     */
    public function meetingroom_appoint()
    {
        $uid = \input('user_id');
        if (empty($uid))
            return \show(0, '请求信息不完整', '', 201);
        $list = Db::name('ServiceMeetingroomAppoint sma')
            ->join('ParkMeetingRoom pmr', 'sma.meetingroom_id=pmr.id')
            ->where('user_id', 'eq', $uid)
            ->field('pmr.room_number,pmr.room_img,FROM_UNIXTIME(sma.s_time) as start_time,FROM_UNIXTIME(sma.e_time) as end_time,sma.status')
            ->select();
        foreach ($list as &$v) {
            $v['room_img'] = \request()->domain() . $v['room_img'];
            if ($v['status'] == 1){
                $v['status'] = '预约成功';
            }elseif($v['status'] == 0){
                $v['status'] = '预约中,请耐心等待';
            }else{
                $v['status'] = '预约失败';
            }

        }
        return \show(1, 'OK', $list, 200);
    }
}