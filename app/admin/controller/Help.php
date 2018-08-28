<?php

namespace app\admin\controller;

use think\Db;

/**
 * Class Help
 * @package app\admin\controller
 */
class Help extends Base
{
    /**
     * @return mixed
     * @throws \think\exception\DbException
     * 软件列表页
     */
    public function soft()
    {
        $key = \input('key');
        $map['soft_name'] = ['like', "%" . $key . "%"];
        $soft_list = \db('Soft')->where('soft_name', 'like', "%" . $key . "%")->order('createtime ace')->paginate(\config('paginate.list_rows'), false, ['query' => get_query()]);
        $show = $soft_list->render();
        $show = $show = preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)", "<a href='javascript:ajax_page($1);'>$2</a>", $show);
        $this->assign([
            'soft_list' => $soft_list,
            'page' => $show,
            'val' => $key
        ]);
        if (\request()->isAjax()) {
            $this->fetch('ajax_soft_list');
        } else {
            return $this->fetch();
        }
    }

    /**
     *执行添加软件操作
     */
    public function soft_runadd()
    {
        if (!\request()->isAjax()) {
            $this->error('提交方式不正确', url('admin/Help/soft'));
        } else {
            //处理图片
            $img_url = '';
            $file = request()->file('file0');
            if ($file) {
                if (config('storage.storage_open')) {
                    $upload = \Qiniu::instance();
                    $info = $upload->upload();
                    $error = $upload->getError();
                    if ($info) {
                        $img_url = config('storage.domain') . $info[0]['key'];
                    } else {
                        $this->error($error, url('admin/Help/soft'));//否则就是上传错误，显示错误原因
                    }
                } else {
                    $validate = config('upload_validate');
                    $info = $file->validate($validate)->rule('uniqid')->move(ROOT_PATH . config('upload_path') . DS . date('Y-m-d'));
                    if ($info) {
                        $img_url = config('upload_path') . '/' . date('Y-m-d') . '/' . $info->getFilename();
                        //写入数据库
                        $data['uptime'] = time();
                        $data['filesize'] = $info->getSize();
                        $data['path'] = $img_url;
                        Db::name('plug_files')->insert($data);
                    } else {
                        $this->error($file->getError(), url('admin/Help/soft'));//否则就是上传错误，显示错误原因
                    }
                }
            }
            //构建数组
            $sqldata = [
                'soft_name' => \input('soft_name'),
                'soft_ico' => $img_url,
                'soft_desc' => \input('soft_content'),
                'createtime' => \time(),
                'soft_status' => \input('soft_open','0'),
                'soft_url' => \input('soft_url')
            ];

            $soft_id = Db::name('soft')->insertGetId($sqldata);
            if (!$soft_id) {
                $this->error('添加失败', \url('soft'));
            } else {
                $this->success('添加成功', \url('soft'));
            }
        }
    }

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 修改软件页面
     */
    public function soft_edit()
    {
        $soft_id = \input('soft_id');
            $soft_info = \db('soft')->where('soft_id', 'eq', $soft_id)->find();
            $this->assign(
                ['soft_info' => $soft_info]
            );
            return $this->fetch();
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 执行修改操作
     */
    public function runEdit()
    {
        $soft_id = \input('soft_id');
        if (!\request()->isPost()) {
            $this->error('提交方式不正确!');
        } else {
            //处理图片
            $img_url = '';
            $file = request()->file('file0');
            if ($file) {
                if (config('storage.storage_open')) {
                    $upload = \Qiniu::instance();
                    $info = $upload->upload();
                    $error = $upload->getError();
                    if ($info) {
                        $img_url = config('storage.domain') . $info[0]['key'];
                    } else {
                        $this->error($error, url('admin/Help/soft'));//否则就是上传错误，显示错误原因
                    }
                } else {
                    $validate = config('upload_validate');
                    $info = $file->validate($validate)->rule('uniqid')->move(ROOT_PATH . config('upload_path') . DS . date('Y-m-d'));
                    if ($info) {
                        $img_url = config('upload_path') . '/' . date('Y-m-d') . '/' . $info->getFilename();
                        //写入数据库
                        $data['uptime'] = time();
                        $data['filesize'] = $info->getSize();
                        $data['path'] = $img_url;
                        Db::name('plug_files')->insert($data);
                    } else {
                        $this->error($file->getError(), url('admin/Help/soft'));//否则就是上传错误，显示错误原因
                    }
                }
            }else{
                $img_url = \input('old_soft_ico');
            }
            //构建数组
            $sqldata = [
                'soft_name' => \input('soft_name'),
                'soft_ico' => $img_url,
                'soft_desc' => \input('soft_content'),
                'updatetime' => \time(),
                'soft_status' => \input('soft_status','0'),
                'soft_url' => \input('soft_url')
            ];
            $res = \db('soft')->where('soft_id', 'eq', $soft_id)->update($sqldata);
            if ($res == false) {
                $this->error('修改失败', \url('soft'));
            } else {
                $this->success('修改成功', \url('soft'));
            }
        }
    }


    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 删除软件--真删除哦
     */
    public function soft_del()
    {
        $soft_id = input('soft_id');
        $rst = Db::name('Soft')->where(['soft_id' => $soft_id])->delete();
        if ($rst !== false) {
            $this->success('删除成功', url('admin/Help/soft'));
        } else {
            $this->error('删除失败', url('admin/Help/soft'));
        }
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 全部删除
     */
    public function soft_Alldel()
    {
        $p = input('p');
        $ids = input('id/a');
        if (empty($ids)) {
            $this->error("请选择删除软件", url('admin/Help/soft', array('p' => $p)));//判断是否选择了软件ID
        }
        if (is_array($ids)) {
            //判断获取软件ID的形式是否数组
            $where = 'soft_id in(' . implode(',', $ids) . ')';
        } else {
            $where = 'soft_id=' . $ids;
        }
        $rst = \db('Soft')->where($where)->delete();
        if ($rst !== false) {
            $this->success("删除成功！", url('admin/Help/soft', array('p' => $p)));
        } else {
            $this->error("删除失败！", url('admin/Help/soft', array('p' => $p)));
        }
    }

    /**
     *更改显示状态
     */
    public function soft_state(){
        $id=input('x');
        $db = \db('soft');
        $status=$db->where(array('soft_id'=>$id))->value('soft_status');
        if($status==1){
            $statedata = array('soft_status'=>0);
            $db->where(array('soft_id'=>$id))->setField($statedata);
            $this->success('状态禁止');
        }else{
            $statedata = array('soft_status'=>1);
            $db->where(array('soft_id'=>$id))->setField($statedata);
            $this->success('状态开启');
        }
    }
}