<?php
/**
 * Created by PhpStorm.
 * User: xpwsg
 * Date: 2018/8/29
 * Time: 10:49
 */

namespace app\admin\controller;


use app\admin\model\ParkBuilding;
use app\admin\model\ParkMeetingRoom;
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
        //按照租赁状态
        $opentype_check = input('status', '');
        //按照楼层
        $floor = \input('floor', '');
        //按照期数
        $phase = \input('phase', '');

        $where = array();
        if ($opentype_check !== '') {
            $where['status'] = $opentype_check;
        }
        if ($floor !== '') {
            $where['floor'] = $floor;
        }
        if ($phase !== '') {
            $where['phase'] = $phase;
        }
        $list = Db::name('ParkRoom pr')
            ->where($where)
            ->order('phase,floor,room_number')
            ->paginate(config('paginate.list_rows'), false, ['query' => get_query()]);
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $building = Db::name('ParkBuilding')->where('status', 'eq', 1)->select();
        $this->assign('building', $building);
        $this->assign('status', $opentype_check);
        $this->assign('floor', $floor);
        $this->assign('phase', $phase);
        $this->assign('list', $list);
        $this->assign('page', $show);
        if (request()->isAjax()) {
            return $this->fetch('ajax_room_list');
        } else {
            return $this->fetch();
        }
    }

    /**
     *添加房间
     */
    public function room_add()
    {
        $building = Db::name('ParkBuilding')->where('status', 'eq', 1)->select();
        $this->assign('building', $building);
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
        //检测是否已存在改房间号
        $count = Db::name('ParkRoom')
            ->where('floor', 'eq', \input('floor'))
            ->where('room_number', 'eq', \input('room_number'))
            ->count();
        if ($count > 0) {
            $this->error('改房源已存在');
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
            'phase' => \input('phase'),
            'floor' => \input('floor'),
            'room_number' => \trim(\input('room_number')),
            'area' => \input('area'),
            'price' => \input('price', 0),  //房租
            'property' => \input('property', 0),     //物业费
            'aircon' => \input('aircon', 0),     //空调费
            'decoration' => \input('decoration'),
            'status' => \input('status'),
            'room_img' => $img_one,//封面图片路径
            'room_pic_type' => \input('room_pic_type'),
            'room_pic_allurl' => $picall_url,//多图路径
            'room_pic_content' => \input('room_pic_content', ''),
            'content' => \htmlspecialchars_decode(input('news_content')),
            'listorder' => \input('listorder', 50, 'intval'),
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
        $id = \input('id');
        $info = Db::name('ParkRoom')->where('id', 'eq', $id)->find();
        $text = $info['room_pic_allurl'];
        $pic_list = array_filter(explode(",", $text));
        $status = [
            0 => '未租',
            1 => '已租',
            2 => '自留',
            3 => '已定',
            4 => '已售'

        ];
        $building = Db::name('ParkBuilding')->where('status', 'eq', 1)->select();
        $this->assign('building', $building);
        $this->assign('info', $info);
        $this->assign('pic_list', $pic_list);
        $this->assign('status', $status);
        return $this->fetch();
    }

    /**
     *执行编辑操作
     */
    public function room_runedit()
    {
        if (!request()->isAjax()) {
            $this->error('提交方式不正确', url('admin/Park/room_list'));
        }

        //获取图片上传后路径
        $pic_oldlist = input('pic_oldlist');//老多图字符串
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
            'id' => \input('id'),
            'phase' => \input('phase'),
            'floor' => \input('floor'),
            'room_number' => \trim(\input('room_number')),
            'area' => \input('area'),
            'price' => \input('price', 0),
            'property' => \input('property', 0),     //物业费
            'aircon' => \input('aircon', 0),     //空调费
            'decoration' => \input('decoration'),
            'decoration' => \input('decoration'),
            'room_img' => $img_one,//封面图片路径
            'room_pic_type' => \input('room_pic_type'),
            'room_pic_allurl' => $picall_url,//多图路径
            'room_pic_content' => \input('room_pic_content', ''),
            'content' => \htmlspecialchars_decode(input('news_content')),
            'listorder' => \input('listorder', 50, 'intval'),
            'status' => \input('status'),
            'create_time' => \time()
        );
        if (!empty($img_one)) {
            $sl_data['room_img'] = $img_one;
        } else {
            $sl_data['room_img'] = \input('oldcheckpic');
        }
        $sl_data['room_pic_allurl'] = $pic_oldlist . $picall_url;
        $model = new ParkRoom();
        $rst = $model->save($sl_data, ['id' => \input('id')]);
        if ($rst !== false) {
            $this->success('修改成功,返回列表页', url('admin/Park/room_list'));
        } else {
            $this->error('修改失败', url('admin/Park/room_list'));
        }
    }

    /**
     *房间状态
     */
    public function room_state()
    {

    }

    /**
     *删除房间
     */
    public function room_delete()
    {
        $p = input('p');
        $id = input('id');
        $rst = Db::name('ParkRoom')
            ->where('id', 'eq', $id)
            ->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Park/room_list', array('p' => $p)));
        } else {
            $this->error('删除失败', url('admin/Park/room_list', array('p' => $p)));
        }
    }


    /**
     *会议室列表
     */
    public function meeting_room_list()
    {
        //按照状态
        $opentype_check = input('status', '');

        //按照期数
        $phase = \input('phase', '');

        $where = array();
        if ($opentype_check !== '') {
            $where['status'] = $opentype_check;
        }

        if ($phase !== '') {
            $where['phase'] = $phase;
        }
        $model = new ParkMeetingRoom();
        $list = $model
            ->where($where)
            ->order('create_time desc')
            ->paginate(config('paginate.list_rows'), false, ['query' => get_query()]);
        $show = $list->render();
        $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign('status', $opentype_check);
        $this->assign('phase', $phase);
        $this->assign('list', $list);
        $this->assign('page', $show);
        if (request()->isAjax()) {
            return $this->fetch('ajax_meeting_room_list');
        } else {
            return $this->fetch();
        }
        return $this->fetch();
    }

    /**
     *增加会议室页面
     */
    public function meeting_room_add()
    {
        $equipment = Db::name('MeetingEquipment')->select();
        $this->assign('equipment', $equipment);
        return $this->fetch();
    }

    /**
     *执行增加会议室
     */
    public function meeting_room_runadd()
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
            'phase' => \input('phase'),
            'room_number' => \trim(\input('room_number')),
            'area' => \input('area'),
            'capacity' => \input('capacity'),
            'equipment' => \serialize(\input('equipment/a')),
//            'price' => \input('price', 0),
            'room_img' => $img_one,//封面图片路径
            'room_pic_type' => \input('room_pic_type'),
            'room_pic_allurl' => $picall_url,//多图路径
            'room_pic_content' => \input('room_pic_content', ''),
            'content' => \htmlspecialchars_decode(input('news_content')),
            'listorder' => \input('listorder', 50, 'intval'),
            'create_time' => \time()
        );
        $model = new ParkMeetingRoom();
        $model->allowField(true)->save($sl_data);

        $continue = input('continue', 0, 'intval');
        if ($continue) {
            $this->success('添加成功,继续发布', url('admin/Park/meeting_room_add'));
        } else {
            $this->success('添加成功,返回列表页', url('admin/Park/meeting_room_list'));
        }
    }

    /**
     *编辑会议室
     */
    public function meeting_room_edit()
    {
        $id = \input('id');
        $info = \model('ParkMeetingRoom')->where('id', 'eq', $id)->find();
        $equipment = \model('ParkMeetingRoom')->where('id', 'eq', $id)->value('equipment');
        $this->assign('equipment', $equipment);
        $this->assign('info', $info);
        return $this->fetch();
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
        $id = input('x');
        $model = new ParkMeetingRoom();
        $status = $model->where(array('id' => $id))->value('status');
        if ($status == 1) {
            $statedata = array('status' => 0);
            $model->where(array('id' => $id))->setField($statedata);
            $this->success('状态禁止');
        } else {
            $statedata = array('status' => 1);
            $model->where(array('id' => $id))->setField($statedata);
            $this->success('状态开启');
        }
    }

    /**
     *删除会议室
     */
    public function meeting_room_delete()
    {
        $id = input('id');
        $p = input('p');
        $model = new ParkMeetingRoom();
        if (empty($id)) {
            $this->error('参数错误', url('admin/Park/meeting_room_list', array('p' => $p)));
        } else {
            $rst = $model->where('id', 'eq', $id)->delete();
            if ($rst !== false) {
                $this->success('删除成功', url('admin/Park/meeting_room_list', array('p' => $p)));
            } else {
                $this->error("删除失败！", url('admin/Park/meeting_room_list', array('p' => $p)));
            }
        }
    }


    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 楼宇列表
     */
    public function add_building()
    {
        $model = new ParkBuilding();
        $list = $model->select();
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     *添加楼宇
     */
    public function building_runadd()
    {
        $sqldata = [
            'name' => \input('name'),
            'status' => \input('status'),
            'create_time' => \date('Y-m-d H:i:s')
        ];
        $res = Db::name('ParkBuilding')->insert($sqldata);
        if ($res) {
            $this->success('添加成功');
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 编辑楼宇信息
     */
    public function building_edit()
    {
        $building_id = input('id');
        $building = Db::name('ParkBuilding')->where('id', $building_id)->find();
        $data = [
            'code' => 1,
            'id' => $building_id,
            'name' => $building['name'],
        ];
        return \json($data);
    }


    /**
     *执行编辑楼宇操作
     */
    public function building_runedit()
    {
        if (!request()->isAjax()) {
            $this->error('提交方式不正确', url('admin/Park/add_building'));
        } else {
            $rst = Db::name('ParkBuilding')
                ->where('id', \input('building_id'))
                ->setField('name', \input('building_name'));
            if ($rst !== false) {
                $this->success('修改成功', url('admin/Park/add_building'));
            } else {
                $this->error('修改失败', url('admin/Park/add_building'));
            }

        }
    }

    /**
     *修改楼宇状态
     */
    public function building_state()
    {
        $id = input('x');
        if (!$id) {
            $this->error('ID:' . $id . '不存在', url('admin/Park/add_building'));
        }
        $status = Db::name('ParkBuilding')->where(array('id' => $id))->value('status');//判断当前状态情况
        if ($status == 1) {
            $statedata = array('status' => 0);
            Db::name('ParkBuilding')->where(array('id' => $id))->setField($statedata);
            $this->success('状态禁止');
        } else {
            $statedata = array('status' => 1);
            Db::name('ParkBuilding')->where(array('id' => $id))->setField($statedata);
            $this->success('状态开启');
        }
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 删除楼宇
     */
    public function building_del()
    {
        $id = \input('id');
        $res = Db::name('ParkBuilding')->where('id', 'eq', $id)->delete();
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}