<?php

// 后台路由

use app\middleware\Auth;
use think\facade\Route;

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
    Route::get('/', A('Index@indexHtml'));
    Route::get('product', A('Product@indexHtml'));
})->middleware(Auth::class);


// 需要登录的（接口）
Route::group($adminPrefix . '/api', function () {})->middleware(Auth::class);
