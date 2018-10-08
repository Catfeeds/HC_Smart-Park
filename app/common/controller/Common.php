<?php

namespace app\common\controller;

use think\Controller;
use think\Lang;
use think\captcha\Captcha;

/**
 * Class Common
 * @package app\common\controller
 */
class Common extends Controller
{
    // Request实例
    /**
     * @var
     */
    protected $lang;

    /**
     *
     */
    protected function _initialize()
    {
        parent::_initialize();
        if (!defined('__ROOT__')) {
            $_root = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
            define('__ROOT__', (('/' == $_root || '\\' == $_root) ? '' : $_root));
        }
        if (!file_exists(ROOT_PATH . 'data/install.lock')) {
            //不存在，则进入安装
            header('Location: ' . url('install/Index/index'));
            exit();
        }
        if (!defined('MODULE_NAME')) {
            define('MODULE_NAME', $this->request->module());
        }
        if (!defined('CONTROLLER_NAME')) {
            define('CONTROLLER_NAME', $this->request->controller());
        }
        if (!defined('ACTION_NAME')) {
            define('ACTION_NAME', $this->request->action());
        }
        // 多语言
        if (config('lang_switch_on')) {
            $this->lang = Lang::detect();
        } else {
            $this->lang = config('default_lang');
        }
        $this->assign('lang', $this->lang);

        if (\config('login_region_protect')) {
            $this->check_login_region();
        }
    }


    /**
     *空操作
     */
    public function _empty()
    {
        $this->error(lang('operation not valid'));
    }

    /**
     * @param $id
     * @return \think\Response
     */
    protected function verify_build($id)
    {
        ob_end_clean();
        $verify = new Captcha (config('verify'));
        return $verify->entry($id);
    }

    /**
     * @param $id
     */
    protected function verify_check($id)
    {
        $verify = new Captcha ();
        if (!$verify->check(input('verify'), $id)) {
            $this->error(lang('verifiy incorrect'), url(MODULE_NAME . '/Login/login'));
        }
    }

    /**
     * @return mixed
     */
    protected function check_admin_login()
    {
        return model('admin/Admin')->is_login();
    }

    /**
     *只允许淮安的ip登录
     */
    protected function check_login_region()
    {
        $ip = \request()->ip();
        $content = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
        $ip_info = json_decode(trim($content), true);
        if ((empty($ip_info['data']['region_id']) || $ip_info['data']['region_id'] != '320000')) {
            header("HTTP/1.0 404 Not Found");
            echo 'HTTP / 1.0 404 Not Found';
            exit;
        }
    }
}