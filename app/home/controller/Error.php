<?php

namespace app\home\controller;

class Error extends Base
{
    //空控制器
    public function index()
    {
        $this->error(lang('operation not valid'));
    }
}