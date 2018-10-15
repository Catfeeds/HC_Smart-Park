<?php

/**
 * Project:www.hc.gov
 * Editor:xpwsg
 * Time:22:00
 * Date:2018/8/28
 */

use think\Route;

/**
 * 标 识       请求类型   路由规则         对应操作方法
 *  index        GET        test            index
 * create        GET        test/create        create
 * save        POST    test            save
 * read        GET        test/:id        read
 * edit        GET        test/:id/edit    edit
 * update        PUT        test/:id        update
 * delete        DELETE    test/:id        delete
 */
//-------用于定时任务接口-------------------------
//自动生成账单接口,
Route::get('bill', 'api/cron.Bill/index');
//自动删除runtime文件夹
Route::get('deldir', 'api/cron.Runtime/index');
//-----------定时任务列表结束-----------------------

//检测更新
Route::resource('version', 'api/Version');
//首页接口
Route::resource('index', 'api/v1.index');
//搜索框接口
Route::post('search', 'api/v1.search/search');
//新闻接口
Route::resource('news', 'api/v1.news');
//党风建设
Route::resource('pnews', 'api/v1.PartyNews');

//轮播图接口
Route::resource('banner', 'api/v1.banner');
//短信验证码
Route::resource('sms', 'api/v1.sms');
//个人注册
Route::resource('register', 'api/v1.register');
//登录
Route::resource('login', 'api/v1.login');
//企业模块
Route::resource('enterprise', 'api/v1.enterprise');


//个人中心各种操作
Route::resource('center', 'api/v1.center');
//修改手机号
Route::post('update_phone', 'api/v1.center/update_phone');
//修改用户名
Route::post('update_username', 'api/v1.center/update_username');
//设置头像
Route::post('avatar', 'api/v1.center/avatar');
//绑定企业
Route::post('bind', 'api/v1.center/bind_enterprise');
//设置密码
Route::post('pwd', 'api/v1.center/setpwd');
//我的活动
Route::post('my_activity', 'api/v1.center/my_activity');
//我的报修
Route::post('my_repair', 'api/v1.repair/my_repair');
//报修的加急和撤回
Route::post('repair/status', 'api/v1.repair/change_status');
//我的论坛
Route::post('my_forum', 'api/v1.center/my_forum');
//论坛发帖
Route::post('add_forum', 'api/v1.center/add_forum');
//我的会议室预定
Route::post('my_meeting', 'api/v1.center/meetingroom_appoint');
//发布新帖
Route::post('add_forum', 'api/v1.center/add_forum');
//删除帖子
Route::post('dele_forum', 'api/v1.center/dele_forum');


//上传图片
Route::resource('upload', 'api/v1.upload');
//投诉建议
Route::resource('complains', 'api/v1.complains');
//报修模块
Route::resource('repair', 'api/v1.repair');
//会议室模块
Route::resource('meetingroom', 'api/v1.meetingroom');
Route::post('appoint', 'api/v1.meetingroom/appoint');

//点赞模块
Route::resource('zan', 'api/v1.zan');
//活动模块
Route::resource('activity', 'api/v1.activity');
//论坛模块
Route::resource('forum', 'api/v1.forum');
//房源模块--列表
Route::get('room_list', 'api/v1.room/room_list');
//房源模块--详情
Route::get('room_detail', 'api/v1.room/room_detail');
//房源模块--预约
Route::post('room_visit', 'api/v1.room/room_visit');