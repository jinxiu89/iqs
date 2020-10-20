<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

/***
 * 20190506
 * 后台GET组
 * 用于处理后台get请求
 *
 */
Route::group('wavlink', function () {
    Route::get('/login', 'auth/login');
    Route::get('/logout', 'auth/logout');
    Route::get('/index', 'index/index');
    Route::get('/category/list', 'Drivers.category/index');
    Route::get('/category/add', 'Drivers.category/add');
    Route::get("/category/edit/:id", 'Drivers.category/edit')->parent(['id' => '\d+']);
    Route::get('/driver/list', 'Drivers.driver/index');
    Route::get('/driver/add', 'Drivers.driver/add');
    Route::post('/driver/add', 'Drivers.driver/add');

    Route::get('/aws/uploader', 'aws/uploader');
    Route::get('/files/edit/:id', 'files/edit')->parent(['id' => '\d+']);
    Route::get('/files/:id/download/add', 'downloads/add')->parent(['id' => '\d+']);
    Route::get('/files/:id/download/edit', 'downloads/list')->parent(['id' => '\d+']);
    Route::get('/files/download/edit/:id', 'downloads/edit_download')->parent(['id' => '\d+']);
    Route::get('/drivers/list', 'Drivers.driver/index');
})->prefix('admin/');


/***
 * 所有的post 都放在post组里
 * post组
 */
Route::group('wavlink', function () {
    Route::post('/login', 'auth/login');
    Route::post('/category/add', 'Drivers.category/add');
    Route::post('/category/edit/:id', 'Drivers.category/edit')->parent(['id' => '\d+']);
    Route::post('/files/add', 'files/add');
    Route::post('/aws/uploader', 'aws/uploader');
    Route::post('/files/download/edit/:id', 'downloads/edit_download')->parent(['id' => '\d+']);
    Route::post('/files/download/del/:id','downloads/del')->parent(['id' => '\d+']);
    Route::post('/files/:id/download/add', 'downloads/add');
    Route::post('/files/edit/:id', 'files/edit')->parent(['id' => '\d+']);

})->prefix('admin/');
