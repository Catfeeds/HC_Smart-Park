<?php

/**
 * Project:www.hc.gov
 * Editor:xpwsg
 * Time:22:00
 * Date:2018/8/28
 */
use think\Route;

/**
 *  index	GET	test	index
    create	GET	test/create	create
    save	POST	test	save
    read	GET	test/:id	read
    edit	GET	test/:id/edit	edit
    update	PUT	test/:id	update
    delete	DELETE	test/:id	delete
 */
Route::resource('test','api/test');