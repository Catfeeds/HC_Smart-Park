<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 10:49
 */

namespace app\admin\controller;


use app\admin\model\ParkRoom;
use think\Db;

/**
 * Class Park
 * @package app\admin\controller
 * 园区管理控制器
 */
class Park extends Base
{
    /**
     *园区信息总览
     */
    public function index()
    {
        return "这里是园区总览";
    }

    /**
     *房源列表
     */
    public function room_list()
    {
        return $this->fetch();
    }

    /**
     *添加房间
     */
    public function room_add()
    {
        return $this->fetch();
    }

    /**
     *执行添加操作
     */
    public function room_runadd()
    {
        if (!request()->isAjax()) {
            $this->error('提交方式不正确', url('admin/Park/room_list'));
        }
        //上传图片部分
        $img_one = '';
        $picall_url = '';
        $file = request()->file('pic_one');
        $files = request()->file('pic_all');
        if ($file || $files) {
            if (config('storage.storage_open')) {
                //七牛
                $upload = \Qiniu::instance();
                $info = $upload->upload();
                $error = $upload->getError();
                if ($info) {
                    if ($file && $files) {
                        //单图,多图都有的情况
                        if (!empty($info['pic_one']))
                            $img_one = config('storage.domain') . $info['pic_one'][0]['key'];
                        if (!empty($info['pic_all'])) {
                            foreach ($info['pic_all'] as $file) {
                                $img_url = config('storage.domain') . $file['key'];
                                $picall_url = $img_url . ',' . $picall_url;
                            }
                        }
                    } elseif ($file) {
                        //只有单图
                        $img_one = config('storage.domain') . $info[0]['key'];
                    } else {
                        //只有多图
                        foreach ($info as $file) {
                            $img_url = config('storage.domain') . $file['key'];
                            $picall_url = $img_url . ',' . $picall_url;
                        }
                    }
                } else {
                    $this->error($error, url('admin/Park/room_list'));//否则就是上传错误，显示错误原因
                }
            } else {
                $validate = config('upload_validate');
                //单图
                if ($file) {
                    $info = $file[0]->validate($validate)->rule('uniqid')->move(ROOT_PATH . config('upload_path') . DS . date('Y-m-d'));
                    if ($info) {
                        $img_url = config('upload_path') . '/' . date('Y-m-d') . '/' . $info->getFilename();
                        //写入数据库
                        $data['uptime'] = time();
                        $data['filesize'] = $info->getSize();
                        $data['path'] = $img_url;
                        Db::name('plug_files')->insert($data);
                        $img_one = $img_url;
                    } else {
                        $this->error($file->getError(), url('admin/Park/room_list'));//否则就是上传错误，显示错误原因
                    }
                }
                //多图
                if ($files) {
                    foreach ($files as $file) {
                        $info = $file->validate($validate)->rule('uniqid')->move(ROOT_PATH . config('upload_path') . DS . date('Y-m-d'));
                        if ($info) {
                            $img_url = config('upload_path') . '/' . date('Y-m-d') . '/' . $info->getFilename();
                            //写入数据库
                            $data['uptime'] = time();
                            $data['filesize'] = $info->getSize();
                            $data['path'] = $img_url;
                            Db::name('plug_files')->insert($data);
                            $picall_url = $img_url . ',' . $picall_url;
                        } else {
                            $this->error($file->getError(), url('admin/Park/room_list'));//否则就是上传错误，显示错误原因
                        }
                    }
                }
            }
        }
        $sl_data = array(
            'phase' => input('phase'),
            'floor' => input('floor'),
            'room_number' => \input('room_number'),
            'area' => \input('area'),
            'price' => \input('price', 0),
            'decoration' => \input('decoration'),
            'room _img' => $img_one,//封面图片路径
            'room_pic_type' => input('room_pic_type'),
            'room_pic_allurl' => $picall_url,//多图路径
            'room_pic_content' => input('room_pic_content', ''),
            'content' => htmlspecialchars_decode(input('news_content')),
            'news_auto' => session('admin_auth.member_id'),
            'listorder' => input('listorder', 50, 'intval'),
            'create_time' => \time()
        );
        $model = new ParkRoom();
        $model->allowField(true)->save($sl_data);

        $continue = input('continue', 0, 'intval');
        if ($continue) {
            $this->success('添加成功,继续发布', url('admin/Park/room_add'));
        } else {
            $this->success('添加成功,返回列表页', url('admin/Park/room_list'));
        }
    }

    /**
     *编辑房源信息
     */
    public function room_edit()
    {

    }

    /**
     *执行编辑操作
     */
    public function room_runedit()
    {

    }

    /**
     *房间状态
     */
    public function room_status()
    {

    }

    /**
     *删除房间
     */
    public function room_delete()
    {

    }

    /**
     *会议室列表
     */
    public function meeting_room_list()
    {

    }

    /**
     *增加会议室页面
     */
    public function meeting_room_add()
    {

    }

    /**
     *执行增加会议室
     */
    public function meeting_room_runadd()
    {

    }

    /**
     *编辑会议室
     */
    public function meeting_room_edit()
    {

    }

    /**
     *执行编辑会议室操作
     */
    public function meeting_room_runedit()
    {

    }

    /**
     *修改会议室状态
     */
    public function meeting_room_status()
    {

    }

    /**
     *删除会议室
     */
    public function meeting_room_delete()
    {

    }
}