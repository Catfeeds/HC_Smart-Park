<?php

namespace app\admin\controller;

class Error extends Base
{
    public function index()
	{
        $this->error('此操作无效');
    }
}