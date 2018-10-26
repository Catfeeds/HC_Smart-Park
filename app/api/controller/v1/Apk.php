<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/26
 * Time: 10:20
 */

namespace app\api\controller\v1;


use think\Controller;

class Apk extends Controller
{
    public function index(){
        $url = \config('app_version.download_url');
        $this->redirect($url);
    }
}