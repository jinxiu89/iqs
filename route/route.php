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
use think\facade\Request;
use think\facade\Route;

// 生成验证码
Route::rule('/verify/code$', 'base/Common/verify', 'GET')->name('gen_verify');
Route::get('/$','frontend/Home/index')->name('front_index');
Route::get('/drivers$','frontend/Drivers/index')->name('front_drivers');
Route::get('/drivers/:url_title','frontend/Drivers/details')->name('front_drivers_details')->parent(['url_title'=>'[a-zA-Z0-9]+']);

Route::get('/manuals$','frontend/Manuals/index')->name('front_manuals');
