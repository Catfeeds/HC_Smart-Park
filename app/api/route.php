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
//首页接口
Route::resource('index', 'api/v1.index');
//新闻接口
Route::resource('news', 'api/v1.news');
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
Route::post('update_phone', 'api/v1.center/update_phone');
Route::post('update_username', 'api/v1.center/update_username');
Route::post('bind', 'api/v1.center/bind_enterprise');
Route::post('pwd', 'api/v1.center/setpwd');
Route::post('my_activity','api/v1.center/my_activity');
Route::post('my_repair','api/v1.repair/my_repair');
//上传图片
Route::resource('upload', 'api/v1.upload');
//投诉建议
Route::resource('complains', 'api/v1.complains');
//投诉建议
Route::resource('repair', 'api/v1.repair');
Route::post('repair/status', 'api/v1.repair/change_status');
//点赞模块
Route::resource('zan', 'api/v1.zan');
//活动模块
Route::resource('activity', 'api/v1.activity');