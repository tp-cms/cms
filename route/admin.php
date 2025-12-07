<?php

use app\admin\middleware\Auth;
use think\facade\Route;

// 后台路由
$adminPrefix = adminRoutePrefix();

// 不需要登录的
// 登录页面
Route::get($adminPrefix . '/login', A('User@login'));
Route::group($adminPrefix . '/api', function () {
    Route::post('user/login', A('User@login'));
    // 验证码
    Route::get('captcha', A('Captcha@generate'));
    // 退出
    Route::post('user/logout', A('User@logout'));
});


// 需要登录的（页面）
Route::group($adminPrefix, function () {
    // 首页
    Route::get('/', A('Index@indexHtml'));
    // 产品
    Route::get('product/create', A('Product@createHtml'));
    Route::get('product/update/:id', A('Product@updateHtml'));
    Route::get('product/index', A('Product@indexHtml'));
})->middleware(Auth::class);


// 需要登录的（接口）
Route::group($adminPrefix . '/api', function () {
    // 产品
    Route::post('product/list', A('Product@index'));
    Route::post('product/create', A('Product@create'));
    Route::post('product/update', A('Product@update'));
    Route::post('product/delete', A('Product@delete'));

    // 文件
    Route::post('file/upload', A('File@upload'));
})->middleware(Auth::class);
