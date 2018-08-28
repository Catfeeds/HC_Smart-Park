<?php


namespace app\admin\model;

use think\Model;

/**
 * 前台菜单模型
 * @package app\admin\model
 */
class Menu extends Model
{
	public function news()
	{
		return $this->hasMany('News','news_columnid')->bind('menu_name');
	}
}
