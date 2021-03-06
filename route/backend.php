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
    Route::get('/driver/edit/:id', 'Drivers.driver/edit')->parent(['id' => '\d+']);
    Route::post('/driver/edit/:id', 'Drivers.driver/edit')->parent(['id' => '\d+']);
    Route::get('/driver/:id/download/add', 'Drivers.downloads/add')->parent(['id' => '\d+']);
    Route::post('/driver/:id/download/add', 'Drivers.downloads/add')->parent(['id' => '\d+']);
    Route::post('/driver/download/delete$', 'Drivers.downloads/delete_download')->name('driver_delete'); //删除下载项

    Route::get('/driver/:id/:file_id/download/edit', 'Drivers.downloads/edit')->parent(['id' => '\d+','file_id'=>'\d+']);
    Route::post('/driver/:id/:file_id/download/edit', 'Drivers.downloads/edit')->parent(['id' => '\d+','file_id'=>'\d+']);


    Route::post('/image/uploader', 'Common/ImageUpload');

    Route::get('/attachment/list','Attachment/index')->parent(['parent_id'=>'\d+'])->name('attachment_list');

    Route::get('/attachment/upload','Attachment/upload')->name('attachment_upload')->parent(['parent_id'=>'\d+']);
    Route::post('/attachment/upload','Attachment/upload')->name('attachment_upload')->parent(['parent_id'=>'\d+']);
    Route::post('/attachment/delete','Attachment/delete')->name('attachment_delete');

    Route::get('/attachment/category/add','AttachmentCategory/add')->name('attachment_category');
    Route::post('/attachment/category/add','AttachmentCategory/add')->name('attachment_category');

    Route::get('/attachment/category/edit','AttachmentCategory/edit')->name('attachment_edit_category')->parent(['id'=>'\d+']);
    Route::post('/attachment/category/edit','AttachmentCategory/edit')->name('attachment_edit_category')->parent(['id'=>'\d+']);
})->prefix('admin/');
//Route::post('/manager/modify','admin/Manager/modify'); 零时用了一下 后期追溯删除

/***
 * 所有的post 都放在post组里
 * post组
 * 黄芪 60g 当归 15g 干姜15g 酸枣仁 15g 桃仁15g 浮小麦 20g 山药30g 葛根 20g 金银花 15g 菟丝子 20g
 * 黄芪30 当归15 柴胡25 黄芩10 酸枣仁15 桃仁15 浮小麦20 菟丝子20
 */
Route::group('wavlink', function () {
    Route::post('/login', 'auth/login');
    Route::post('/category/add', 'Drivers.category/add');
    Route::post('/category/edit/:id', 'Drivers.category/edit')->parent(['id' => '\d+']);
    Route::post('/files/add', 'files/add');
})->prefix('admin/');
